<?php

namespace App\Http\Controllers\API\V1;

use Exception;
use App\Models\Page;
use App\Models\Role;
use App\Models\User;
use App\Models\ShopSetting;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\RegistrationInfoMail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validation_rules = [
            'email' => 'required|email',
            'password' => 'required',
        ];
        $messages = [
            'email.required' => 'Email is required',
            'email.email' => 'Email is invalid',
            'password.required' => 'Password is required',
        ];

        $validator = validateRules($validation_rules, $messages);
        if ($validator->fails()) {
            return sendError('Validation Error', $validator->errors());
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $success['id'] =  $user->id;
            $success['name'] =  $user->name;
            $success['email'] =  $user->email;
            $success['phone'] =  $user->phone;
            $success['image'] =  getFilePath($user->avatar);
            $success['token_type'] =  'Bearer';
            $success['token'] =  $user->createToken('MyApp')->plainTextToken;
            $success['role'] =  $user->role->name;
            $success['role_id'] =  $user->role_id;

            return sendResponse('User login successfully.', $success);
        } else {
            return sendError('User Not Found.', ['error' => 'Unauthorised']);
        }
    }

    public function registration(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'phone' => 'required',
            'type'  => 'required|integer|in:3,4,5',
            'shop_name' => 'required_if:type,3',
            'designer_id' => 'required_if:type,4|exists:users,id',
            'password' => 'required|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return sendError('Validation Error.', $validator->errors());
        }

        try {
            $response = [];

            if ($request->type == 3) {
                $response = $this->designerRegister($request);
            } else if ($request->type == 4) {
                $response = $this->userRegister($request);
                $user = $response[1];
                Mail::to($user->email)->send(new RegistrationInfoMail($user));
            } else if ($request->type == 5) {
                $response =  $this->manufacturerRegister($request);
                $user = $response[1];
                Mail::to($user->email)->send(new RegistrationInfoMail($user));
            }

            $messages = $response[0];
            $user = $response[1];


            $success = [];
            $success['id'] =  $user->id;
            $success['name'] =  $user->name;
            $success['email'] =  $user->email;
            $success['phone'] =  $user->phone;
            $success['image'] =  getFilePath($user->avatar);
            $success['token_type'] =  'Bearer';
            $success['token'] =  $user->createToken('MyApp')->plainTextToken;
            $success['role'] =  $user->role->name;
            $success['role_id'] =  $user->role_id;

            return sendResponse($messages, $success);
        } catch (Exception $e) {
            return $e;
            return sendError('Something went wrong', $e);
        }
    }

    public function designerRegister($request)
    {

        $user = new User();
        $user->name = $request->name;
        $user->password = Hash::make($request->password);
        $user->email = $request->email;
        $user->role_id = Role::DESIGNER;
        $user->active_status = 0;
        $user->save();

        $shop_setting = new ShopSetting();
        $shop_setting->user_id = $user->id;
        $shop_setting->shop_name = $request->shop_name;
        $shop_setting->slug = createShopSlug($request->shop_name);
        $shop_setting->save();

        foreach (Page::pages as $page) {
            $pg = new \App\Models\Page();
            $pg->title = $page;
            if ($page == "About Us") {
                $slug = Str::slug('About');
            }elseif($page == "Contact Us"){
                $slug = Str::slug('Contact');
            }else{
                $slug = Str::slug($page);
            }
            $pg->slug = $slug;
            $pg->short_desc = 'This is ' . $page . ' page';
            $pg->content = '<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>';
            $pg->meta_title = $page;
            $pg->meta_description = '<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>';
            if ($page == 'About Us' || $page == 'Our Story' || $page == 'Contact Us') {
                $pg->footer_widget_id = 1;
            } elseif ($page == 'Team' || $page == 'Blog') {
                $pg->footer_widget_id = 2;
            } else {
                $pg->footer_widget_id = 3;
            }
            $pg->user_id = $user->id;
            $pg->save();
        }


        return ['Designer registered successfully.', $user];
    }
    public function userRegister($request)
    {


        $user = new User();
        $user->name = $request->name;
        $user->password = Hash::make($request->password);
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->role_id = Role::CUSTOMER;
        $user->designer_id = $request->designer_id;
        $user->active_status = 1;

        $user->save();


        return ['User registered successfully.', $user];
    }
    public function manufacturerRegister($request)
    {

        $user = new User();
        $user->name = $request->name;
        $user->password = Hash::make($request->password);
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->role_id = Role::MANUFACTURER;
        $user->active_status = 1;
        $user->save();

        return ['Manufacturer registered successfully.', $user];
    }





    public function sendPasswordResetToken(Request $request)
    {
        $validation_rules = [
            'email' => 'required|email',
        ];
        $messages = [
            'email.required' => 'Email is required',
        ];

        $validator = validateRules($validation_rules, $messages);

        if ($validator->fails()) {
            return sendError('Validation Error.', $validator->errors());
        }

        $status = Password::sendResetLink($request->only('email'));

        if ($status == Password::RESET_LINK_SENT) {
            return [
                'status' => __($status)
            ];
        } elseif ($status == Password::RESET_THROTTLED) {
            return sendError('Password reset link already been sent. Check your email.');
        } else {
            return sendError('User Not Found.', ['error' => 'Unauthorised']);
        }
    }


    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();
                $user->tokens()->delete();
            }
        );

        if ($status == Password::PASSWORD_RESET) {
            return sendResponse($status, 'Password changed successfully.');
        }else
        {
            return sendError('Credential did not matched');
        }
    }


    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return sendResponse('User logout successfully.');
    }
}
