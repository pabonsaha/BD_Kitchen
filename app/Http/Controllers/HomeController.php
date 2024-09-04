<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\ShopSetting;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //

    public function index()
    {
        $shops = ShopSetting::with('user')->get();
        return view('user.home',compact('shops'));
    }
}
