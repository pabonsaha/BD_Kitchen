<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Laravel\Cashier\Billable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\GatewayCredentials;
use App\Models\SubscriptionPaymentLog;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Billable, CanResetPassword;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];



    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function role()
    {
        return $this->hasOne(Role::class, 'id', 'role_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public function shop()
    {
        return $this->hasOne(ShopSetting::class);
    }
    public function portfolio()
    {
        return $this->hasMany(SpecialSection::class)->where('type', 1);
    }
    public function inspiration()
    {
        return $this->hasMany(SpecialSection::class)->where('type', 2);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function shippingAddress()
    {
        return $this->hasMany(ShippingAddress::class);
    }

    public function gatewayCredentials()
    {
        return $this->hasMany(GatewayCredentials::class);
    }
    public function paymentMethodStatus()
    {
        return $this->hasMany(PaymentMethodStatus::class);
    }

    public function currentSubscription()
    {
        return $this->hasOne(SubscriptionPaymentLog::class)->latest();
    }
    public function subscriptionPaymentLogs()
    {
        return $this->hasMany(SubscriptionPaymentLog::class)->orderBy('id', 'desc');
    }
}
