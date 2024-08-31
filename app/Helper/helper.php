<?php

use Carbon\Carbon;
use App\Models\Role;
use App\Models\User;
use App\Models\Product;
use App\Models\ShopSetting;
use Illuminate\Support\Str;
use App\Models\GlobalSetting;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

if (!function_exists('generalSetting')) {
    function generalSetting()
    {
        return app('general_Setting');
    }
}

if (!function_exists('globalSetting')) {
    function globalSetting($key)
    {
        $globalSetting = GlobalSetting::where('key', $key)->where('active_status', 1)->first();
        if ($globalSetting) {
            return $globalSetting;
        } else {
            return '';
        };
    }
}

if (!function_exists('colorTheme')) {
    function colorTheme()
    {
        return app('color_theme');
    }
}
if (!function_exists('shopSetting')) {
    function shopSetting()
    {
        return app('shop_Setting');
    }
}
if (!function_exists('activeLanguages')) {
    function activeLanguages()
    {
        return app('active_languages');
    }
}

if (!function_exists('getFilePath')) {
    function getFilePath($path)
    {
        if ($path) {
            return asset('storage/' . $path);
        }
        return asset('/assets/img/placeholder/placeholder.png');
    }
}

if (!function_exists('getUserId')) {
    function getUserId()
    {
        /*
            In this case, role ID 3 is for the designer (system pre-defined) and role ID 5 is for manufacturer (system pre-defined).

            Return the user ID of the designer if the user is a designer;
            otherwise, return the user ID of the super admin, which is always 1.
        */
        if (Auth::user()->role_id == Role::DESIGNER || Auth::user()->role_id == Role::MANUFACTURER) {
            return Auth::user()->id;
        }

        return 1;
    }
}


if (!function_exists('getDesignerID')) {
    function getDesignerID()
    {

        /*
            if request has designer slug than return the user id of designer
            else return the super admin(house brand) id which is 1
        */

        if (request()->has('designer') && !empty(request()->designer) && request()->designer != null) {
            $shop_setting = ShopSetting::where('slug', request()->designer)->first();
            if ($shop_setting)
                return $shop_setting->user_id;
        }
        return 1;
    }
}

if (!function_exists('getSellerIds')) {
    function getSellerIds()
    {
        if (request()->has('designer') && !empty(request()->designer) && request()->designer != null) {
            $shop_setting = ShopSetting::where('slug', request()->designer)->first();
            if ($shop_setting)
                // array return
                return [$shop_setting->user_id];
        } else {
            $manufecturerIds = User::where('role_id', Role::MANUFACTURER)->where('active_status', 1)->pluck('id');
            return $manufecturerIds;
        }
    }
}

if (!function_exists('getSellerIdByProductId')) {
    function getSellerIdByProductId($productId)
    {
        $product = Product::where('id', $productId)->first();
        if ($product->user_id) {
            return $product->user_id;
        }
        return null;
    }
}

if (!function_exists('hasPermissionForOperation')) {

    function hasPermissionForOperation($model)
    {

        /* The only person who is capable of modifying their own data is the designer.
            while a super admin can manage any data. super admin role ID is 1.
        */


        if ($model instanceof \Illuminate\Database\Eloquent\Model) {
            $model = collect([$model]);
        }

        if ($model->isEmpty()) {
            abort(404, 'Not found.');
        }

        foreach ($model as $data) {
            if ($data->user_id !== Auth::user()->id && Auth::user()->role_id !== Role::SUPER_ADMIN && $data->seller_id !== Auth::user()->id) {
                abort(401, 'Unauthorized access.');
            }
        }
    }
}


if (!function_exists('createSlug')) {
    function createSlug($value)
    {
        return Illuminate\Support\Str::slug($value) . md5(uniqid(rand(), true));
    }
}
if (!function_exists('createShopSlug')) {
    function createShopSlug($value)
    {
        $shop_name_count = ShopSetting::where('shop_name', $value)->count();
        if ($shop_name_count > 0) {
            return Illuminate\Support\Str::slug($value) . ($shop_name_count + 1);
        }

        return Illuminate\Support\Str::slug($value);
    }
}

function dateFormat($date)
{
    return Carbon::parse($date)->format(generalSetting()->DateFormat->format ?? 'M d, Y');
}

function timeFormat($date)
{
    return Carbon::parse($date)->format('h:i A');
}

function dateFormatwithTime($date)
{
    return Carbon::parse($date)->format(generalSetting()->DateFormat->format . ' h:i A' ?? 'M d Y, h:i A');
}


function getCurrency()
{
    return generalSetting()->currency->symbol;
}

function getPriceFormat($amount)
{
    return getCurrency() . number_format($amount, 2);
}


if (!function_exists('activeMenu')) {
    function activeMenu($route, $output = "active")
    {
        if (Route::is("{$route}.*") || Route::is($route) || url()->current() == $route) {
            return $output;
        }
    }
}

if (!function_exists('openMenu')) {
    function openMenu(array $routes, $output = "open")
    {
        foreach ($routes as $route) {
            if (Route::is("{$route}.*")) {
                return $output;
            }
        }
    }
}

// Permission check
if (!function_exists('hasPermission')) {
    function hasPermission($keyword)
    {
        if (Auth::user()->role->permissions && in_array($keyword, Auth::user()->role->permissions)) {
            return true;
        }
        return false;
    }
}


// ENV Configurations
if (!function_exists('putEnvConfigration')) {
    function putEnvConfigration($envKey, $envValue)
    {
        $envValue = str_replace('\\', '\\' . '\\', $envValue);
        $value = '"' . $envValue . '"';
        $envFile = app()->environmentFilePath();
        $str = file_get_contents($envFile);

        $str .= "\n";
        $keyPosition = strpos($str, "{$envKey}=");


        if (is_bool($keyPosition)) {

            $str .= $envKey . '="' . $envValue . '"';
        } else {
            $endOfLinePosition = strpos($str, "\n", $keyPosition);
            $oldLine = substr($str, $keyPosition, $endOfLinePosition - $keyPosition);
            $str = str_replace($oldLine, "{$envKey}={$value}", $str);

            $str = substr($str, 0, -1);
        }

        if (!file_put_contents($envFile, $str)) {
            return false;
        } else {
            return true;
        }
    }
}

if (!function_exists('perPage')) {
    function perPage()
    {
        return request()->get('per_page', 10);
    }
}


if (!function_exists('breadcrumb')) {
    function breadcrumb($title, $list)
    {
        $output = '<div class="row">
            <div class="col-12">
                <div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="dashboard_header_title">
                                <h3>' . @$title . '</h3>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="dashboard_breadcam text-right">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">
                                            <a href="' . url('/dashboard') . '">Dashboard</a>
                                        </li>';
        if ($list != null) {
            foreach ($list as $url => $value) {
                if ($url === array_key_last($list)) {
                    $output .= '<li class="breadcrumb-item active" aria-current="page">' . $value . '</li>';
                } else {
                    $output .= '<li class="breadcrumb-item">';
                    $output .= '<a href="' . url($url) . '">' . $value . '</a>';
                    $output .= '</li>';
                }
            }
        }
        $output .= '</ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>';

        return $output;
    }
}
if (!function_exists('dataInfo')) {
    function dataInfo($data)
    {
        $output = '';
        if ($data->created_by != null) {
            $output = '<p class="badge bg-label-dark data-info mb-2">Created By:  ' . $data->createdBy->name . ' </br>' . dateFormatwithTime($data->created_at) . '</p>';
        }
        if ($data->updated_by != null) {
            $output .= '<p class="badge bg-label-secondary data-info mb-0">Updated By: ' . $data->updatedBy->name . ' </br>' . dateFormatwithTime($data->updated_at) . '</p>';
        }
        return $output;
    }
}
if (!function_exists('getRoleName')) {
    function getRoleName($roleIds)
    {
        $role = Role::where('id', $roleIds)->first();
        $roleName = $role->name;
        return $roleName;
    }
}


function getFileElement($filePath)
{
    // Get file extension
    $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

    // Check if file is an image
    $isImage = in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp']);

    // Check if file is a supported document type
    $isDocument = in_array($extension, ['pdf', 'docx', 'csv']);

    // Return appropriate HTML element based on file type
    if ($isImage) {
        return '
        <div class="thumb flex-shrink-0 mh_40 mw_40">
        <a href="' . $filePath . '" target="_blank">
        <img  height="80px;" width="80px;" class="img img-fluid" src="' . $filePath . '">
        </a>
        </div>
        ';
    } elseif ($isDocument) {
        return '
        <div class="thumb flex-shrink-0 mh_40 mw_40">
        <a href="' . $filePath . '" target="_blank">
        <img  height="80px;" width="80px;" class="img img-fluid"  src="' . asset('/assets/img/file_icons/' . $extension . '.png') . '">
        </a>
        </div>';
    } else {
        return '
        <div class="thumb flex-shrink-0 mh_40 mw_40">
        <img  height="80px;" width="80px;" class="img img-fluid"  src="' . asset('/assets/img/file_icons/file.png') . '">
        </div>';
    }
}

// capitalize
if (!function_exists('textCapitalize')) {
    function textCapitalize($text)
    {
        $sanitized = preg_replace('/[^a-zA-Z0-9\s]/', ' ', $text);
        $sanitized = preg_replace('/\s+/', ' ', $sanitized);
        $titleCased = ucwords(strtolower($sanitized));
        return $titleCased;
    }
}


if (!function_exists('_translation')) {
    function _translation($key)
    {
        $trans = trans($key);
        // dd($trans);
        try {
            // $exp = explode('.', $trans);

            $txt = $trans;
            $txt = Str::replace('_', ' ', ucfirst($txt));
            $txt = ucfirst($txt);
            return $txt;
        } catch (\Throwable $th) {
            return $key;
        }
    }
}
if (!function_exists('userLocal')) {
    function userLocal()
    {
        try {
            $user = auth()->user();
            if (isset($user->language)) {
                $user_lang = $user->language;
            } else {
                $user_lang = App::getLocale();
            }
            return $user_lang;
        } catch (\Throwable $th) {
            return 'en';
        }
    }
}

if (!function_exists('_trans')) {
    function _trans($value)
    {

        try {
            if (env('APP_ENV') == 'production') {
                return trans($value);
            } else {

                $local = userLocal() ? userLocal() : app()->getLocale();

                $langPath = base_path('lang/' . $local . '/');
                if (!file_exists($langPath)) {
                    mkdir($langPath, 0777, true);
                }
                if (str_contains($value, '.')) {
                    $new_trns = explode('.', $value);
                    $file_name = $new_trns[0];
                    // $trans_key = $new_trns[1];
                    $trans_key = str_replace($file_name . '.', '', $value);

                    $file_path = $langPath . '' . $file_name . '.php';
                    if (file_exists($file_path)) {
                        $file_content = include($file_path);

                        if (array_key_exists($trans_key, $file_content)) {
                            return _translation($value);
                        } else {
                            $file_content[$trans_key] = $trans_key;
                            $str = <<<EOT
                                            <?php
                                                return [
                                            EOT;
                            foreach ($file_content as $key => $val) {
                                if (gettype($val) == 'string') {

                                    $line = <<<EOT
                                                                    "{$key}" => "{$val}",\n
                                                                EOT;
                                }
                                if (gettype($val) == 'array') {
                                    $line = <<<EOT
                                                                            "{$key}" => [\n
                                                                        EOT;
                                    $str .= $line;
                                    foreach ($val as $lang_key => $lang_val) {

                                        $line = <<<EOT
                                                                            "{$lang_key}" => "{$lang_val}",\n
                                                                        EOT;

                                        $str .= $line;
                                    }

                                    $line = <<<EOT
                                                                        ],\n
                                                                    EOT;
                                }

                                $str .= $line;
                            }
                            $end = <<<EOT
                                                    ]
                                            ?>
                                            EOT;
                            $str .= $end;

                            file_put_contents($file_path, $str, $flags = 0, $context = null);
                        }
                    } else {

                        fopen($file_path, 'w');
                        $file_content = [];
                        $file_content[$trans_key] = $trans_key;
                        $str = <<<EOT
                                            <?php
                                                return [
                                            EOT;
                        foreach ($file_content as $key => $val) {
                            if (gettype($val) == 'string') {

                                $line = <<<EOT
                                                                    "{$key}" => "{$val}",\n
                                                                EOT;
                            }
                            if (gettype($val) == 'array') {
                                $line = <<<EOT
                                                                            "{$key}" => [\n
                                                                        EOT;
                                $str .= $line;
                                foreach ($val as $lang_key => $lang_val) {

                                    $line = <<<EOT
                                                                            "{$lang_key}" => "{$lang_val}",\n
                                                                        EOT;

                                    $str .= $line;
                                }

                                $line = <<<EOT
                                                                        ],\n
                                                                    EOT;
                            }

                            $str .= $line;
                        }
                        $end = <<<EOT
                                                    ]
                                            ?>
                                            EOT;
                        $str .= $end;

                        file_put_contents($file_path, $str, $flags = 0, $context = null);
                    }
                    return _translation($value);
                } else {

                    $trans_key = $value;
                    $file_path = base_path('lang/' . $local . '/' . $local . '.php');

                    fopen($file_path, 'w');
                    $file_content = [];
                    $file_content[$trans_key] = $trans_key;
                    $str = <<<EOT
                                            <?php
                                                return [
                                            EOT;
                    foreach ($file_content as $key => $val) {
                        if (gettype($val) == 'string') {

                            $line = <<<EOT
                                                                    "{$key}" => "{$val}",\n
                                                                EOT;
                        }
                        if (gettype($val) == 'array') {
                            $line = <<<EOT
                                                                            "{$key}" => [\n
                                                                        EOT;
                            $str .= $line;
                            foreach ($val as $lang_key => $lang_val) {

                                $line = <<<EOT
                                                                            "{$lang_key}" => "{$lang_val}",\n
                                                                        EOT;

                                $str .= $line;
                            }

                            $line = <<<EOT
                                                                        ],\n
                                                                    EOT;
                        }

                        $str .= $line;
                    }
                    $end = <<<EOT
                                                    ]
                                            ?>
                                            EOT;
                    $str .= $end;

                    file_put_contents($file_path, $str, $flags = 0, $context = null);
                    return _translation($value);
                }
                return _translation($value);
            }
        } catch (Exception $exception) {
            return $value;
        }
    }
}

if (!function_exists('getEmbedUrl')) {
    function getEmbedUrl($url)
    {
        // function for generating an embed link
        $finalUrl = '';

        if (strpos($url, 'facebook.com/') !== false) {
            // Facebook Video
            $finalUrl.='https://www.facebook.com/plugins/video.php?href='.rawurlencode($url).'&show_text=1&width=200';
        } elseif (strpos($url, 'vimeo.com/') !== false) {
            // Vimeo video
            $videoId = isset(explode("vimeo.com/", $url)[1]) ? explode("vimeo.com/", $url)[1] : null;
            if (strpos($videoId, '&') !== false) {
                $videoId = explode("&", $videoId)[0];
            }
            $finalUrl.='https://player.vimeo.com/video/'.$videoId;
        } elseif (strpos($url, 'youtube.com/') !== false) {
            // Youtube video
            $videoId = isset(explode("v=", $url)[1]) ? explode("v=", $url)[1] : null;
            if (strpos($videoId, '&') !== false) {
                $videoId = explode("&", $videoId)[0];
            }
            $finalUrl.='https://www.youtube.com/embed/'.$videoId;
        } elseif (strpos($url, 'youtu.be/') !== false) {
            // Youtube  video
            $videoId = isset(explode("youtu.be/", $url)[1]) ? explode("youtu.be/", $url)[1] : null;
            if (strpos($videoId, '&') !== false) {
                $videoId = explode("&", $videoId)[0];
            }
            $finalUrl.='https://www.youtube.com/embed/'.$videoId;
        } elseif (strpos($url, 'dailymotion.com/') !== false) {
            // Dailymotion Video
            $videoId = isset(explode("dailymotion.com/", $url)[1]) ? explode("dailymotion.com/", $url)[1] : null;
            if (strpos($videoId, '&') !== false) {
                $videoId = explode("&", $videoId)[0];
            }
            $finalUrl.='https://www.dailymotion.com/embed/'.$videoId;
        } else {
            $finalUrl.=$url;
        }
        return $finalUrl;
    }
}
