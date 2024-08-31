<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SpecialSectionDetailsItemsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'title'  => $this->title,
            'description' => $this->description,
            'amount' => $this->amount,
            'image' => $this->image ? getFilePath($this->image) : null,
        ];
    }
}
