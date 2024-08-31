<?php

namespace App\Http\Controllers;

use App\Mail\InvoiceMail;
use Illuminate\Support\Facades\Mail;
use PDF;
use Exception;
use Carbon\Carbon;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use App\Models\OrderStatus;
use App\Models\ShopSetting;
use Illuminate\Http\Request;
use App\Models\ShippingAddress;
use Illuminate\Support\Facades\DB;
use Brian2694\Toastr\Facades\Toastr;
use App\Http\Requests\OrderStoreRequest;
use Yajra\DataTables\Facades\DataTables;

use App\Http\Requests\OrderUpdateRequest;
use App\Http\Requests\IdValidationRequest;


class OrderController extends Controller
{
    public function index(Request $request)
    {

        if ($request->ajax()) {

            $data = Order::where('seller_id', getUserId())->withCount('items')->with(['user', 'orderStatus']);
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('order_date', function ($row) {
                    return dateFormat($row->order_date);
                })
                ->addColumn('name', function ($row) {
                    return $row->user->name;
                })
                ->filter(function ($instance) use ($request) {
                    if ($request->get('status')) {
                        $instance->whereHas('orderStatus', function ($query) use ($request) {
                            $query->where('id', $request->get('status'));
                        });
                    }
                })
                ->editColumn('status', function ($row) {
                    // return $row->orderStatus->name;
                    return '<span class="btn btn btn-label-secondary waves-effect"' . 'style="color:' . $row->orderStatus->color . '!important;">' . $row->orderStatus->name . '</span>';
                })
                ->addColumn('action', function ($row) {
                    $btn = '';
                    if (hasPermission('customer_order_list_edit')) {
                        $btn .= '<a href="' . route('order.edit', $row) . '" class="btn btn-success text-white me-1" >Edit</a>';
                    }
                    if (hasPermission('customer_order_list_details')) {
                        $btn .= '<a href="' . route('order.details', $row) . '" class="btn btn-primary text-white me-1" >Details</a>';
                    }
                    if (hasPermission('customer_order_list_read_invoice')) {
                        $btn .= '<a href="' . route('order.invoicePreview', $row) . '" class="btn btn-warning text-white" ><i class="menu-icon tf-icons ti ti-file-dollar"></i>Invoice</a>';
                    }
                    return $btn;
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }

        $orderStatus = OrderStatus::all();
        return view('order.index', compact('orderStatus'));
    }

    /**
     * @param Request $request
     *
     * @return [json]
     */
    public function store(OrderStoreRequest $request)
    {
        try {
            DB::beginTransaction();

            $shipping_addresses = ShippingAddress::where('id', $request->shippingAddressId)->where('user_id', $request->user_id)->first();



            if (!$shipping_addresses) {
                DB::rollBack();
                Toastr::error('Shipping Address did not found');
                return redirect()->back();
            }

            $shipping_addresses_arary = [];

            $shipping_addresses_arary['name'] = $shipping_addresses->name;
            $shipping_addresses_arary['email'] = $shipping_addresses->email;
            $shipping_addresses_arary['phone'] = $shipping_addresses->phone;
            $shipping_addresses_arary['country'] = $shipping_addresses->country;
            $shipping_addresses_arary['state'] = $shipping_addresses->state;
            $shipping_addresses_arary['street_address'] = $shipping_addresses->street_address;
            $shipping_addresses_arary['zip_code'] = $shipping_addresses->zip_code;

            $order = new Order();
            $order->user_id = $request->user_id;
            $order->seller_id = getUserId(); //here user id refer to designer id
            $order->code =  $this->generateOrderID();
            $order->shipping_address = json_encode($shipping_addresses_arary);
            $order->note = $request->note;
            $order->sub_total_amount = $request->sub_total;
            $order->admin_discount_type = $request->discount_type;
            $order->admin_discount_value = $request->discount_value;
            $order->admin_discount_amount = $request->discount_amount;
            $order->tax_type = $request->tax_type;
            $order->tax_value = $request->tax_value;
            $order->tax_amount = $request->tax_amount;
            $order->shipping_charges = $request->shipping_charge;
            $order->grand_total_amount = $request->total;
            $order->order_date = Carbon::now();

            $order->save();

            foreach ($request->product as $item) {
                $order_item = new OrderItem();

                $order_item->order_id = $order->id;
                $order_item->seller_id = getUserId();
                $order_item->user_id = $request->user_id;
                $order_item->product_id = $item['product_id'];
                $order_item->unit_price = $item['price'];
                $order_item->price = $item['price'];
                $order_item->quantity = $item['quantity'];
                $variant_value = [];
                if (array_key_exists('variant', $item)  && sizeof($item['variant'])) {
                    foreach ($item['variant'] as $variant) {
                        $value = [
                            'attribute' => $variant['attribute'],
                            'value' => $variant['value'],
                        ];
                        array_push($variant_value, $value);
                    }
                }

                $order_item->variation = $variant_value;

                $order_item->save();
            }

            Cart::where('user_id', $request->user_id)->where('seller_id', getUserId())->delete();

            DB::commit();

            Toastr::success('Order Placed Successfully');
            return redirect()->route('cart.index');
        } catch (Exception $e) {
            DB::rollBack();
            return abort(404, "Something went wrong");
        }
    }

    public function details($order_id)
    {
        $order = Order::with(['items.product', 'user', 'items.statusLog.status', 'orderStatus'])
            ->find($order_id);

        $status = OrderStatus::where('active_status',1)->get();
        hasPermissionForOperation($order);
        return view('order.details', compact('order', 'status'));
    }

    public function edit($order_id)
    {
        $order = Order::with(['items.product', 'user'])
            ->find($order_id);

        $products = Product::where('user_id', getUserId())->get();
        $shipping_addresses = ShippingAddress::where('user_id', $order->user_id)->orderBy('id', 'desc')->get();
        hasPermissionForOperation($order);

        return view('order.edit', compact('order', 'products', 'shipping_addresses'));
    }

    public function update(OrderUpdateRequest $request)
    {

        try {
            DB::beginTransaction();

            $order = Order::find($request->order_id);

            hasPermissionForOperation($order);

            if ($request->has('shippingAddressId') && $request->filled('shippingAddressId')) {
                $shipping_addresses = ShippingAddress::where('id', $request->shippingAddressId)->where('user_id', $order->user_id)->first();



                if (!$shipping_addresses) {
                    DB::rollBack();
                    Toastr::error('Shipping Address did not found');
                    return redirect()->back();
                }

                $shipping_addresses_arary = [];

                $shipping_addresses_arary['name'] = $shipping_addresses->name;
                $shipping_addresses_arary['email'] = $shipping_addresses->email;
                $shipping_addresses_arary['phone'] = $shipping_addresses->phone;
                $shipping_addresses_arary['country'] = $shipping_addresses->country;
                $shipping_addresses_arary['state'] = $shipping_addresses->state;
                $shipping_addresses_arary['street_address'] = $shipping_addresses->street_address;
                $shipping_addresses_arary['zip_code'] = $shipping_addresses->zip_code;

                $order->shipping_address = json_encode($shipping_addresses_arary);
            }

            $order->note = $request->note;
            $order->sub_total_amount = $request->sub_total;
            $order->admin_discount_type = $request->discount_type;
            $order->admin_discount_value = $request->discount_value;
            $order->admin_discount_amount = $request->discount_amount;
            $order->tax_type = $request->tax_type;
            $order->tax_value = $request->tax_value;
            $order->tax_amount = $request->tax_amount;
            $order->shipping_charges = $request->shipping_charge;
            $order->grand_total_amount = $request->total;

            $order->save();

            OrderItem::where('order_id', $request->order_id)->delete();

            foreach ($request->product as $item) {
                $order_item = new OrderItem();

                $order_item->order_id = $order->id;
                $order_item->seller_id = getUserId();
                $order_item->user_id = $request->user_id;
                $order_item->product_id = $item['product_id'];
                $order_item->unit_price = $item['price'];
                $order_item->price = $item['price'];
                $order_item->quantity = $item['quantity'];
                $variant_value = [];
                // dd($item['variant']);
                if (array_key_exists('variant', $item)  && sizeof($item['variant'])) {
                    foreach ($item['variant'] as $variant) {

                        $value = [
                            'attribute' => $variant['attribute'],
                            'value' => $variant['value'],
                        ];
                        array_push($variant_value, $value);
                    }
                }
                $order_item->variation = $variant_value;

                $order_item->save();
            }

            DB::commit();

            Toastr::success('Order Update Successfully');
            return redirect()->route('order.index');
        } catch (Exception $e) {
            DB::rollBack();
            return abort(404, "Something went wrong");
        }
    }

    public function destroy(IdValidationRequest $request)
    {
        try {
            $order = Order::find($request->order_id);
            hasPermissionForOperation($order);
            $order->status = 5;
            $order->save();

            return response()->json(['text' => 'Order has been deleted.', 'icon' => 'success']);
        } catch (Exception $e) {
            return response()->json(['text' => "Something went wrong"]);
        }
    }

    public function invoicePreview($order_id)
    {
        $order = Order::with(['items.product', 'user'])
            ->find($order_id);
        hasPermissionForOperation($order);
        return view('order.invoice-preview', compact('order'));
    }

    public function invoicePrint($order_id)
    {
        $setting = shopSetting();

        $order = Order::with(['items.product', 'user'])
            ->find($order_id);
        hasPermissionForOperation($order);
        return view('order.invoice', compact('order', 'setting'));
    }

    public function invoiceDownload($order_id)
    {
        $setting = shopSetting();

        $order = Order::with(['items.product', 'user'])
            ->find($order_id);
        hasPermissionForOperation($order);

        $pdf = PDF::setOptions([
            'isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true,
            'logOutputFile' => storage_path('logs/log.htm'),
            'tempDir' => storage_path('logs/'),
        ])->loadView('order.invoice', compact('order', 'setting'));
        return $pdf->download($order->code . '.pdf');
        // return $pdf->stream();
    }

    public function generateInvoicePDF($order_id)
    {
        $setting = shopSetting();

        $order = Order::with(['items.product', 'user'])
            ->find($order_id);

        hasPermissionForOperation($order);

        $pdf = PDF::setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
            'logOutputFile' => storage_path('logs/log.htm'),
            'tempDir' => storage_path('logs/'),
        ])->loadView('order.invoice', compact('order', 'setting'));

        return $pdf->output();
    }


    public function sendInvoice(Request $request)
    {
        try {
            $orderId = $request->input('order_id');
            $recipientEmail = $request->input('invoice-to');
            $subject = $request->input('invoice-subject');
            $messageContent = $request->input('message');

            $order = Order::with(['items.product', 'user'])->findOrFail($orderId);

            $pdf = $this->generateInvoicePDF($orderId);

            Mail::to($recipientEmail)->send(new InvoiceMail($order, $pdf, $messageContent, $subject));

            Toastr::success('Success', "Invoice sent successfully");
        } catch (\Exception $e) {
            Toastr::error('Error', "Failed to send invoice!");
        }
        return redirect()->back();
    }


    // Generate custom order ID
    public function generateOrderID()
    {
        $timestamp = time();
        return "ORD-{$timestamp}";
    }

    public function getProduct($id)
    {
        $product = Product::with('choiceOptions', 'variants')->find($id);

        return $product;
    }


}
