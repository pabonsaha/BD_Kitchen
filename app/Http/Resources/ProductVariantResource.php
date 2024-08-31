<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductVariantResource extends JsonResource
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
            'product_id' => $this->product_id,
            'variant' => $this->variant,
            'sku' => $this->sku,
            'price' => $this->price,
            'qty' => $this->qty,
            'image' => $this->image ? asset(getFilePath($this->image)):null,
        ];
    }
}
