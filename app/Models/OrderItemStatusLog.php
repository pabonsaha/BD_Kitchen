<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItemStatusLog extends Model
{
    use HasFactory;

    public function status()
    {
        return $this->belongsTo(OrderStatus::class,'order_status_id');
    }
}
