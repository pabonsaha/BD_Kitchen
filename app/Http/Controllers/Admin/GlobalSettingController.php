<?php

namespace App\Http\Controllers;

use App\Models\GlobalSetting;
use Illuminate\Http\Request;

class GlobalSettingController extends Controller
{
    public function index()
    {
        $settings = GlobalSetting::all();
        return view('setting.global-setting', compact('settings'));
    }


    public function update(Request $request)
    {

        try {
            $setting = GlobalSetting::findOrFail($request->id);
            if($setting->value == 1){
                $setting->value = 0;
            }else{
                $setting->value = 1;
            }
            $setting->save();
            return response()->json(['message' => 'Setting Successfully Updated!',], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Something is Wrong!',], 500);
        }
    }
}
