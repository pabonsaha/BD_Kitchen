<?php

namespace App\Http\Controllers;

use App\Models\GatewayCredentials;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\PaymentMethodStatus;
use App\Services\StripeService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Brian2694\Toastr\Facades\Toastr;


class MyOrderController extends Controller
{
    //

    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = Order::where('user_id', getUserId())->withCount('items')->with(['designer', 'orderStatus']);
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('order_date', function ($row) {
                    return dateFormat($row->order_date);
                })
                ->addColumn('name', function ($row) {
                    return $row->designer->name;
                })
                ->editColumn('status', function ($row) {
                    // return $row->orderStatus->name;
                    return '<span class="btn btn btn-label-secondary waves-effect"' . 'style="color:' . $row->orderStatus->color . '!important;">' . $row->orderStatus->name . '</span>';
                })

                ->filter(function ($instance) use ($request) {
                    if ($request->get('status')) {
                        $instance->whereHas('orderStatus', function ($query) use ($request) {
                            $query->where('id', $request->get('status'));
                        });
                    }
                }, true)
                ->addColumn('action', function ($row) {

                    $btn = '<a href="' . route('myOrder.details', $row) . '" class="btn btn-primary text-white me-1" >Details</a>';
                    $btn .= '<a href="' . route('myOrder.makePayment', $row) . '" class="btn btn-primary text-white me-1"><i class="ti ti-credit-card me-2"></i>Payment</a>';
                    return $btn;
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }

        $orderStatus = OrderStatus::all();
         return view('my-order.order.index', compact('orderStatus'));
    }

    public function details($order_id)
    {
        $order = Order::with(['items.product', 'designer', 'items.statusLog.status', 'orderStatus'])
            ->find($order_id);

        hasPermissionForOperation($order);
        return view('my-order.order.details', compact('order'));
    }

    public function cartList(Request $request)
    {
        if ($request->ajax()) {

            $data = DB::table('carts')
                ->where('user_id', getUserId())
                ->join('users', 'carts.user_id', '=', 'users.id')
                ->select('user_id', 'users.name', DB::raw('count(*) as total'))
                ->groupBy('user_id');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $btn = '<a href="' . route('cart.details', $row->user_id) . '" class="btn btn-success text-white" >Details</a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('my-order.cart.index');
    }

    // makePayment
    public function makePayment($order_id)
    {
        $order = Order::find($order_id);
        $stripe = new StripeService();
        $redirectURL = $stripe->makeOrderPayment($order,route('myOrder.checkout-success', [], true),route('myOrder.checkout-cancel', [], true));
        if ($redirectURL) {
            return redirect($redirectURL);
        }

        Toastr::error('Payment gateway is not setup. Please contact to seller');
        return view('order.my-order.details', compact('order'));
    }

    // checkoutSuccess
    public function checkoutSuccess(Request $request)
    {
        try {
            $sessionId = $request->query('session_id');
            $order_id = $request->query('order_id');

            $order = Order::find($order_id);

            $stripe = new StripeService();
            $secret_key = $stripe->getStripeCredential($order->seller_id);

            Stripe::setApiKey($secret_key);
            $payment_detials = $stripe->successPayment($sessionId, $order_id,);

            $order->payment_status = $payment_detials['payment_status'];
            $order->payment_details = json_encode($payment_detials['payment_details']);

            $order->save();
            Toastr::success('Payment successfull');

            return redirect()->route('myOrder.details', $order->id);
        } catch (Exception $e) {
            abort(404, 'Something went wrong.');
        }
    }
}
