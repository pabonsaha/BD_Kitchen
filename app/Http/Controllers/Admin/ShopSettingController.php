<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SiteLogoStoreRequest;
use App\Http\Requests\SocialLinkStoreRequest;
use App\Http\Requests\SystemInfoStoreRequest;
use App\Models\ShopSetting;
use Illuminate\Http\Request;
use App\Http\Traits\FileUploadTrait;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ShopSettingController extends Controller
{
    use FileUploadTrait;

    public function index()
    {
        $setting = shopSetting();

        return view('admin.setting.shop-setting', compact('setting'));
    }

    public function storeSystemInfo(SystemInfoStoreRequest $request)
    {

        try {
            $shop_setting = ShopSetting::where('user_id', Auth::user()->id)->first();

            $shop_setting->shop_name = $request->shop_name;

            $shop_setting->location = $request->address;
            $shop_setting->phone = $request->phone;
            $shop_setting->email = $request->email;
            $shop_setting->map_location = $request->map_location;
            $shop_setting->save();

            // Toastr::success('General Setting Updated');
            return response()->json(['message' => 'Shop Setting Updated', 'status' => 200], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Something went wrong', 'status' => 500], 500);
        }
    }

    public function storeSiteLogo(SiteLogoStoreRequest $request)
    {

        $general_setting = ShopSetting::where('user_id', getUserId())->first();

        try {
            if ($request->hasFile('light_logo')) {
                $path = $this->uploadFile($request->file('light_logo'), 'designer/' . Auth::user()->id . '/icon');

                if ($general_setting->logo) {
                    $this->deleteFile($general_setting->logo);
                }
                $general_setting->logo = $path;
            }
            if ($request->hasFile('banner')) {

                $path = $this->uploadFile($request->file('banner'), 'designer/' . Auth::user()->id . '/icon');
                if ($general_setting->banner) {
                    $this->deleteFile($general_setting->banner);
                }
                $general_setting->banner = $path;
            }
            if ($request->hasFile('favicon')) {

                $path = $this->uploadFile($request->file('favicon'), 'designer/' . Auth::user()->id . '/icon');
                if ($general_setting->favicon) {
                    $this->deleteFile($general_setting->favicon);
                }
                $general_setting->favicon = $path;
            }

            $general_setting->save();

            return response()->json(['message' => 'Shop Logo Updated', 'status' => 200], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Something went wrong', 'status' => 500], 500);
        }
    }

    public function storeSocialLink(SocialLinkStoreRequest $request)
    {

        try {
            $shop_setting = ShopSetting::where('user_id', getUserId())->first();

            $shop_setting->twitter_url = $request->twitter;
            $shop_setting->facebook_url = $request->facebook;
            $shop_setting->instagram_url = $request->instagram;
            $shop_setting->linkedin = $request->linkedin;
            $shop_setting->youtube_url = $request->youtube;
            $shop_setting->tiktok_url = $request->tiktok;

            $shop_setting->save();

            return response()->json(['message' => 'Social Link Updated', 'status' => 200], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Something went wrong', 'status' => 500], 500);
        }
    }

    public function storeTermsPolices(Request $request){
        try {
            $shop_setting = ShopSetting::where('user_id', getUserId())->first();
            $shop_setting->shipping_policy = $request->shipping_policy;
            $shop_setting->return_policy = $request->return_policy;
            $shop_setting->disclaimer = $request->disclaimer;

            $shop_setting->update();
            return response()->json(['message' => 'Terms & Polices Updated', 'status' => 200], 200);
        }catch (Exception $e){
            return response()->json(['message' => 'Something went wrong', 'status' => 403], 403);
        }
    }
}
