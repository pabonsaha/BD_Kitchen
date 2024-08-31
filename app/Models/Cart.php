<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'seller_id', 'product_id', 'quantity', 'variation', 'price'];

    protected $casts = [
        'variation' => 'array',
    ];

    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    public function designer()
    {
        return $this->belongsTo(User::class, 'seller_id', 'id');
    }
}
