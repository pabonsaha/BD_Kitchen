<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductRequestResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'request_id' => $this->id,
            'product' => new ProductListResource($this->whenLoaded('product')),
            'variation' => $this->variation,
            'price' =>$this->price,
            'quantity' =>$this->quantity,
            'status' => $this->stauts == 2 ? 'Canceled' : ($this->stauts == 1 ? 'Approved' : 'Pending'),
        ];
    }
}
