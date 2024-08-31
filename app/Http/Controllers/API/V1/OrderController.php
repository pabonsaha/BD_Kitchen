<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Wishlist;
use PDF;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\OrderListResource;
use App\Http\Resources\OrderDetailsResource;
use App\Services\StripeService;
use Stripe\Stripe;
use Exception;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    //

    public function index()
    {
        $orders = Order::where('user_id', Auth::user()->id)->withCount('items')->with('orderStatus', 'shop')->paginate(perPage());

        return sendResponse('Order List.', OrderListResource::collection($orders)->resource);
    }

    public function details($id)
    {

        $order = Order::with(['items.product', 'shop', 'items.statusLog.status', 'orderStatus'])
            ->find($id);

        if ($order) {
            return sendResponse('Order List.', new OrderDetailsResource($order));
        }

        return sendError('Order Not Found!', null, 404);
    }

    public function count()
    {
        $order_count = Order::where('user_id', Auth::user()->id)->get();

        $total_order = $order_count->count();
        $confirmed_order = $order_count->where('status', '1')->count();
        $procesed_order = $order_count->where('status', '2')->count();
        $delivered_order = $order_count->where('status', '4')->count();
        $cart = Cart::where('user_id', Auth::user()->id)->count();
        $wishlist = Wishlist::where('user_id', Auth::user()->id)->count();

        return sendResponse('Order Count.', [
            'total_order' => $total_order,
            'confirmed_order' => $confirmed_order,
            'procesed_order' => $procesed_order,
            'delivered_order' => $delivered_order,
            'cart' => $cart,
            'wishlist' => $wishlist,
        ]);
    }

    public function invoiceDownload($order_id)
    {
        $setting = shopSetting();

        $order = Order::with(['items.product', 'user'])
            ->find($order_id);
        if (!$order) {
            return sendError('Order does not exits');
        }
        hasPermissionForOperation($order);

        $pdf = PDF::setOptions([
            'isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true,
            'logOutputFile' => storage_path('logs/log.htm'),
            'tempDir' => storage_path('logs/'),
        ])->loadView('order.invoice', compact('order', 'setting'));
        // return $pdf->download($order->code . '.pdf');
        return $pdf->stream($order->code . '.pdf');
    }

    public function makePayment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'success_url' => 'required',
            'cancel_url' => 'required',
            'order_id' => 'required|exists:orders,id|integer',

        ]);

        if ($validator->fails()) {
            return sendError('Validation Error', $validator->errors(), 403);
        }


        $order = Order::find($request->order_id);
        $stripe = new StripeService();
        $redirectURL = $stripe->makeOrderPayment($order, $request->success_url, $request->cancel_url);
        if ($redirectURL) {

            return sendResponse('Payment URL', $redirectURL);
        }

        return sendError('Payment gateway is not setup. Please contact to seller');
    }

    // checkoutSuccess
    public function checkoutSuccess(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'session_id' => 'required',
            'order_id' => 'required|exists:orders,id|integer',

        ]);

        if ($validator->fails()) {
            return sendError('Validation Error', $validator->errors(), 403);
        }


        try {
            $sessionId = $request->session_id;
            $order_id = $request->order_id;

            $order = Order::find($order_id);

            $stripe = new StripeService();
            $secret_key = $stripe->getStripeCredential($order->seller_id);

            Stripe::setApiKey($secret_key);
            $payment_detials = $stripe->successPayment($sessionId, $order_id,);

            $order->payment_status = $payment_detials['payment_status'];
            $order->payment_details = json_encode($payment_detials['payment_details']);
            $order->save();

            return sendResponse('Payment Successfull',[
                'order_id' => $order_id,
                'code' => $order->code,
            ]);
        } catch (Exception $e) {
            return sendError('Something went wrong');
        }
    }
}
