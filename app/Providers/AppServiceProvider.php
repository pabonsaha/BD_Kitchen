<?php

namespace App\Providers;

use App\Models\ColorTheme;
use App\Models\GeneralSetting;
use App\Models\Language;
use App\Models\Role;
use App\Models\ShopSetting;
use Faker\Core\Color;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton('general_Setting', function () {
            return GeneralSetting::with('currency', 'timezone', 'DateFormat')->first();
        });

        $this->app->singleton('color_theme', function () {
            return ColorTheme::where('type', 1)->where('active_status', 1)->first();
        });

        $this->app->singleton('active_languages', function () {
            return Language::where('active_status', 1)->get();
        });

        $this->app->singleton('shop_Setting', function () {
            $id = Role::ADMIN;
            if (Auth::user() && Auth::user()->role_id == Role::KITCHEN) {
                $id = Auth::user()->id;
            }
            return ShopSetting::where('user_id', $id)->first();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        ResetPassword::createUrlUsing(function (User $user, string $token) {
            return env('APP_FRONTEND_URL') . 'auth/reset-password?token=' . $token . '&email=' . $user->email;
        });
    }
}
