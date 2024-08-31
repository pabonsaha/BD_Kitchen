<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ColorThemeResource;
use App\Models\ColorTheme;
use Illuminate\Http\Request;

class ColorThemeController extends Controller
{

    public function colorThemes()
    {
        $colorTheme = ColorTheme::where('type', 0)->where('active_status', 1)->first();
        return sendResponse('Color Themes.', new ColorThemeResource($colorTheme));
    }
}
