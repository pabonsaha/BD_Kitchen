<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ShippingAddress;
use App\Models\ShopSetting;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{

    public function checkout(Request $request)
    {
        $productsIDs = [];

        foreach ($request->products as $product) {
            array_push($productsIDs, $product['id']);
        }

        $products = Product::whereIn("id", $productsIDs)->get();

        foreach ($products as $product) {
            foreach ($request->products as $item) {
                if ($item['id'] == $product->id) {
                    $product->quantity_value=$item['quantity'];
                }
            }

        }
        $shop = ShopSetting::find($request->shop_id);

        return view('user.checkout', compact('products','shop'));

    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

//            $shipping_addresses = ShippingAddress::where('id', $request->shippingAddressId)->where('user_id', $request->user_id)->first();
//
//
//
//            if (!$shipping_addresses) {
//                DB::rollBack();
//                Toastr::error('Shipping Address did not found');
//                return redirect()->back();
//            }

            $shipping_addresses_arary = [];

            $shipping_addresses_arary['name'] = $request->shipping_addresses_name;
            $shipping_addresses_arary['phone'] = $request->shipping_addresses_phone;
            $shipping_addresses_arary['city'] = $request->shipping_addresses_city;
            $shipping_addresses_arary['street_address'] = $request->shipping_addresses_street_address;

            $order = new Order();
            $order->user_id = Auth::user()->id;
            $order->kitchen_id = $request->seller_id; //here user id refer to designer id
            $order->code =  $this->generateOrderID();
            $order->shipping_address = json_encode($shipping_addresses_arary);
            $order->note = $request->note;
            $order->sub_total_amount = $request->sub_total;
            $order->shipping_charges = $request->shipping_charge;
            $order->grand_total_amount = $request->total;
            $order->order_date = Carbon::now();

            $order->save();

            foreach ($request->product as $item) {
                $order_item = new OrderItem();

                $order_item->order_id = $order->id;
                $order_item->kitchen_id = $request->seller_id;
                $order_item->user_id = Auth::user()->id;
                $order_item->product_id = $item['id'];
                $order_item->unit_price = $item['price'];
                $order_item->price = $item['price'];
                $order_item->quantity = $item['quantity'];

                $order_item->save();
            }

            DB::commit();

            Toastr::success('Order Placed Successfully');
            return redirect()->route('home');
        } catch (Exception $e) {
            DB::rollBack();
            return abort(404, "Something went wrong");
        }

    }

    public function generateOrderID()
    {
        $timestamp = time();
        return "ORD-{$timestamp}";
    }
}
