<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\ShopSetting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //

    public function login()
    {
        return view('user.login');
    }

    public function loginConfirm(Request $request)
    {


        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'role_id' => Role::USER])) {
            return redirect()->route('home');
        } else {
            return redirect()->back()->with('message', "credendital didn't matched");
        }
    }

    public function register()
    {

        return view('user.kitchen-register');
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'name' => ['required', 'regex:/^[a-zA-Z]+(?:\s[a-zA-Z]+)+$/', 'string', 'max:50'],
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

    public function userRegister()
    {
        return view('user.user-register');
    }

    public function userRegisterStore(Request $request)
    {

        $validated = $request->validate([
            'name' => ['required', 'regex:/^[a-zA-Z]+(?:\s[a-zA-Z]+)+$/', 'string', 'max:50'],
            'email' => 'required|email|unique:users',
            'phone' => ['required', 'string', 'regex:/^(?:\+88|88)?(01[3-9]\d{8})$/'],
            'password' => 'required|min:6|confirmed',
        ]);
        $user = new User();
        $user->name = $request->name;
        $user->password = Hash::make($request->password);
        $user->email = $request->email;
        $user->role_id = Role::USER;
        $user->active_status = 1;
        $user->save();

        return redirect()->route('login');
    }

    public function logout()
    {
        Auth::guard('web')->logout();
        return redirect('/');
    }
}
