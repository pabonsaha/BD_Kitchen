<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ShopSettingResource;
use App\Models\ShopSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ShopSettingController extends Controller
{
    //
    public function index(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'designer' => 'sometimes|required|exists:shop_settings,slug',
        ]);

        if ($validator->fails()) {

            return sendError($validator->errors());
        }
        $shop_setting = shopSetting();

        if ($request->has('designer') && !empty($request->designer) && $request->designer != null) {
            $shop_setting = ShopSetting::where('slug', $request->designer)->first();
        }

        return sendResponse('Shop Setting', new ShopSettingResource($shop_setting));
    }
}
