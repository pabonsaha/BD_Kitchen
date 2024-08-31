<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WishListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->when($this->product, $this->product->id),
            'slug' => $this->when($this->product, $this->product->slug),
            'name' => $this->when($this->product, $this->product->name),
            'price' => $this->when($this->product, $this->product->discount_price),
            'image' => $this->when($this->product, getFilePath($this->product->thumbnail_img)),
        ];
    }
}
