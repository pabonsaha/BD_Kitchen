<?php

namespace App\Models;

use App\Models\Traits\CommonQueryTraits;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use CommonQueryTraits;
    use HasFactory;
    use \Staudenmeir\EloquentJsonRelations\HasJsonRelationships;

    protected $guarded = [];

    protected $casts = [
        'weight_dimensions' => 'array',
        'specifications' => 'array',
    ];

    protected $appends  = ["discount_price", 'discount_percentage'];

    const FIXED = 1;
    const PERCENTAGE  = 2;




    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }


    public function wishlist()
    {
        return $this->hasOne(Wishlist::class);
    }

    protected function getDiscountPriceAttribute()
    {
        $discount = $this->attributes['discount'];

        if ($this->discount_type == Product::PERCENTAGE) {
            return $this->unit_price - ($this->unit_price * ($discount / 100));
        }
        if ($this->discount_type == Product::FIXED) {
            return $this->unit_price - $discount;
        }
        return null;
    }
    protected function getDiscountPercentageAttribute()
    {
        if ($this->discount_type == Product::PERCENTAGE) {
            return $this->discount;
        }
        if ($this->discount_type == Product::FIXED) {
            return ($this->discount / $this->unit_price) * 100;
        }
        return null;
    }

    public function user()
    {
        return $this->belongsTo(User::class,'kitchen_id');
    }
}
