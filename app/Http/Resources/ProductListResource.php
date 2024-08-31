<?php

namespace App\Http\Resources;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'name' => $this->name,
            'price' => $this->unit_price,
            'discount_price' => $this->discount_price,
            'discountPercentage' => $this->discount_percentage,
            'category' => $this->whenLoaded('category', function () {
                return [
                    'name' => $this->category->name,
                ];
            }),
            'image' => asset(getFilePath($this->thumbnail_img)),
            'wishlist' => (bool)$this->wishlist,
        ];
    }
}
