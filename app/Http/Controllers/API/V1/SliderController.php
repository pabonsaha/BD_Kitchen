<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\SliderResource;
use App\Models\Role;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Collection;

class SliderController extends Controller
{

    public function sliderList($type = null)
    {
        try {
            $data = Slider::where('active_status', 1)->where('type',$type)->where('user_id',getDesignerID())->get();
            return sendResponse('Slider List.', SliderResource::collection($data));
        } catch (\Throwable $th) {
            return sendError('Something went wrong.', $th->getMessage());
        }
    }
}
