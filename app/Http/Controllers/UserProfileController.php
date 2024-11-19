<?php

namespace App\Http\Controllers;

use App\Http\Traits\FileUploadTrait;
use App\Models\ShippingAddress;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Exceptions\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class UserProfileController extends Controller
{
    use fileUploadTrait;
    public function show()
    {
        // Get the currently authenticated user
        $user = Auth::user();
        $shippingAdddresses = ShippingAddress::where('user_id', Auth::user()->id)->get();
        // Pass the user data to the profile view
        return view('profile', compact('user', 'shippingAdddresses'));
    }

    public function update(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'avatar' => 'sometimes|image|mimes:jpeg,png,jpg|max:1024',
            'phone' => 'required|string',

        ]);

        if ($validator->fails()) {
            return sendError('Validation Error', $validator->errors(), 403);
        }

        try {

            $user = User::find(Auth::user()->id);

            $user->name = $request->name;
            $user->address = $request->address;
            $user->phone = $request->phone;
            if ($request->hasFile('avatar')) {

                $path = $this->uploadFile($request->file('avatar'), 'user');
                if ($user->avatar) {
                    $this->deleteFile($user->avatar);
                }
                $user->avatar = $path;
            }

            $user->save();
            Toastr::success('Profile Updated');
            return redirect()->back();
        } catch (Exception $e) {
            return sendError("Something went wrong");
        }
    }
}
