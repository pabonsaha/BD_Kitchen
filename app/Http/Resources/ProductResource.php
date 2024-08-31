<?php

namespace App\Http\Resources;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'name' => $this->name,
            'thumbnail_link' => asset(getFilePath($this->thumbnail_img)),
            'video_link' => $this->video_link,
            'tags' => json_decode($this->tags),
            'description' => $this->description,
            'price' => $this->unit_price,
            'discount_price' => $this->discount_price,
            'discountPercentage' => $this->discount_percentage,
            'unit' => $this->unit,
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
            'meta_img' => asset(getFilePath($this->meta_img)),
            'shipping_policy' => $this->shipping_policy,
            'return_policy' => $this->return_policy,
            'disclaimer' => $this->disclaimer,
            'category' => new CategoryResource($this->category),
            'brand' => new BrandResource($this->brand),
            'variants' => ProductVariantResource::collection($this->variants),
            'images' => ProductImageResource::collection($this->whenLoaded('images')),
            'weight_dimensions' => $this->weight_dimensions,
            'specifications' => $this->specifications,
            'options' => ProductChoiceOptionResource::collection($this->choiceOptions),
            'wishlist' => (bool)$this->wishlist,
        ];
    }
}
