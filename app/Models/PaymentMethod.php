<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;

    public function gatewayCredentials()
    {
        return $this->hasMany(GatewayCredentials::class);
    }
    public function activeStatus()
    {
        return $this->hasOne(PaymentMethodStatus::class);
    }
}
