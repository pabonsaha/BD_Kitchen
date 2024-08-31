<?php

namespace App\Models;

use App\Models\Traits\CommonQueryTraits;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Order extends Model
{
    use HasFactory;
    use CommonQueryTraits;


    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function designer()
    { 
        return $this->belongsTo(User::class, 'seller_id', 'id');
    }

    public function orderStatus()
    {
        return $this->hasOne(OrderStatus::class, 'id', 'status');
    }

    public function shop()
    {
        return $this->belongsTo(ShopSetting::class, 'seller_id', 'user_id');
    }

    protected function shippingAddress(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => json_decode($value),
        );
    }
}
