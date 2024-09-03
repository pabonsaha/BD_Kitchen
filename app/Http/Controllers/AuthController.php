<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\ShopSetting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //

    public function login()
    {
        return view('user.login');
    }

    public function register()
    {

        return view('user.register');
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'kitchen_name' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);
        $user = new User();
        $user->name = $request->name;
        $user->password = Hash::make($request->password);
        $user->email = $request->email;
        $user->role_id = Role::KITCHEN;
        $user->active_status = 1;
        $user->save();

        $shop_setting = new ShopSetting();
        $shop_setting->user_id = $user->id;
        $shop_setting->shop_name = $request->kitchen_name;
        $shop_setting->slug = createShopSlug($request->kitchen_name);
        $shop_setting->save();

        return redirect()->route('admin.login');
    }
}
