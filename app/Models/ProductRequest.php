<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class ProductRequest extends Model
{
    use HasFactory;

    protected $casts = [
        'variation' => 'array',
    ];



    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected function status(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => $value == 2 ? 'Canceled' : ($value == 1 ? 'Approved' : 'Pending'),
        );
    }
}
