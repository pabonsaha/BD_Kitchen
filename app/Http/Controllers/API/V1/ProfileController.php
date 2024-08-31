<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProfileResource;
use App\Http\Resources\UserResource;
use App\Http\Traits\FileUploadTrait;
use App\Models\User;
use Carbon\Exceptions\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    use FileUploadTrait;

    public function index(){
        $user = Auth::user();
        return sendResponse("User Details.", ProfileResource::make($user), 200);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'avatar' => 'sometimes|image|mimes:jpeg,png,jpg|max:1024',

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

            return sendResponse("Profile Updated");
        } catch (Exception $e) {
            return sendError("Something went wrong");
        }
    }

    public function passwordChange(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'password' => 'required|confirmed|min:6',
        ]);

        if ($validator->fails()) {
            return sendError('Validation Error', $validator->errors(), 403);
        }

        try {

            $user = User::find(Auth::user()->id);

            if (Hash::check($request->current_password, $user->password)) {

                $user->password = Hash::make($request->password);
                $user->save();
                return sendResponse("Password Changed Successfully");
            }

            return sendError('Validation Error',  ['confirm_password' => ["Current Password didn't matched"]], 403);
        } catch (Exception $e) {
            return sendError('Something went wrong', $validator->errors(), 403);
        }
    }
}
