<?php

namespace App\Http\Controllers;

use App\Http\Requests\StatusStoreRequest;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderItemStatusLog;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Support\Facades\Auth;

class OrderItemController extends Controller
{
    public function statusStore(StatusStoreRequest $request)
    {

        try {

            $orderItemStatusLog = new OrderItemStatusLog();
            $orderItemStatusLog->order_item_id = $request->order_item_id;
            $orderItemStatusLog->order_status_id = $request->order_item_status;
            $orderItemStatusLog->date_time = $request->order_item_status_date;
            $orderItemStatusLog->active_status = Auth::user()->id;
            $orderItemStatusLog->note = $request->note;
            $orderItemStatusLog->save();

            $orderItem = OrderItem::find($request->order_item_id);
            $order = Order::find($orderItem->order_id);

            $orderItems = OrderItem::where('order_id', $orderItem->order_id)->with('statusLog')->get();

            $partial_delivery = 0;
            $procesed = 0;
            $deliverd = 0;
            $confirmed_delivery = 0;
            $cancel_delivery = 0;

            foreach ($orderItems as $item) {
                if (count($item->statusLog)) {
                    $logStatus = $item->statusLog->last()->order_status_id;
                    if ($logStatus == 9) {
                        $partial_delivery = 1;
                        break;
                    } else if ($logStatus == 4) {
                        $deliverd = 1;
                    } else if ($logStatus == 5) {
                        $cancel_delivery = 1;
                    } else if ($logStatus == 1) {
                        $confirmed_delivery = 1;
                    } else {
                        $procesed = 1;
                    }
                } else {
                    $confirmed_delivery = 1;
                }
            }

            if ($partial_delivery == 1) {
                $order->status = 9;
            } elseif ($deliverd == 1 && $partial_delivery == 0 && $confirmed_delivery == 0 && $procesed == 0) {
                $order->status = 4;
            } elseif ($deliverd == 0 && $partial_delivery == 0 &&  $cancel_delivery == 1 && $confirmed_delivery == 0 && $procesed == 0) {
                $order->status = 5;
            } elseif ($deliverd == 0 && $partial_delivery == 0 &&  $cancel_delivery == 0 && ($confirmed_delivery == 1 || $confirmed_delivery == 0)  && $procesed == 1) {
                $order->status = 2;
            } else {
                $order->status = 1;
            }


            $order->save();

            Toastr::success('Order Item Status Added');
            return response()->json(['message' => 'Order Item Status Added', 'status' => 200], 200);
        } catch (Exception $e) {
            dd($e);
            return response()->json(['message' => 'Something went wrong', 'status' => 500], 500);
        }
    }
}
