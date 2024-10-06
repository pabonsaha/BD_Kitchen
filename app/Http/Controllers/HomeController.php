<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\ShopSetting;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //

    public function index()
    {
        $shops = ShopSetting::with('user')->get();
        return view('user.home', compact('shops'));
    }

    public function kitchens()
    {
        $shops = ShopSetting::with('user')->paginate(12);
        return view('user.kitchens',compact('shops'));
    }
}
