<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function dashboard()
    {
        $totalOrder = Order::isKitchen()->get()->count();
        $cancelOrder = Order::isKitchen()->where('status', 5)->get()->count();
        $processedOrder = Order::isKitchen()->where('status', 2)->get()->count();
        $deliveredOrder = Order::isKitchen()->where('status', 4)->get()->count();

        $totalSale = Order::isKitchen()->where('status', 4)->sum('grand_total_amount');
        $totalSaleCurrentMonth = Order::isKitchen()->where('status', 4)->whereBetween('order_date',
            [
                Carbon::now()->startOfMonth(),
                Carbon::now()->endOfMonth()
            ])->sum('grand_total_amount');

        $totalSaleCurrentYear = Order::isKitchen()->where('status', 4)->whereBetween('order_date',
            [
                Carbon::now()->startOfYear(),
                Carbon::now()->startOfYear()
            ])->sum('grand_total_amount');


        return view('admin.dashboard', compact('totalOrder', 'cancelOrder', 'processedOrder', 'deliveredOrder', 'totalSale', 'totalSaleCurrentMonth', 'totalSaleCurrentYear'));
    }
}
