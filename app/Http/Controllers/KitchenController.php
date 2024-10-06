<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ShopSetting;
use Illuminate\Http\Request;

class KitchenController extends Controller
{
    //

    public function index($slug)
    {
        $shop = ShopSetting::where('slug', $slug)->first();
        $products = Product::where('kitchen_id', $shop->user_id)->get();
        return view('user.kitchen', compact('shop', 'products'));
    }
}
