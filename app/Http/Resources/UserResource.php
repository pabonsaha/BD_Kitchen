<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                => $this->id,
            'name'              => $this->name,
            'phone'             => $this->shop->phone,
            'email'             => $this->shop->email,
            'address'          => $this->shop->location,
            'avatar'            => asset(getFilePath($this->avatar)),
            'status'            => $this->active_status,
            'shop_name'         => $this->shop->shop_name,
            'shop_slug'         => $this->shop->slug,
            'logo'              => asset(getFilePath($this->shop->logo)),
            'banner'            => asset(getFilePath($this->shop->banner)),
            'total_product'     => $this->products_count,
            'total_portfolio'   => $this->portfolio_count,
            'total_inspiration' => $this->inspiration_count,
        ];
    }
}
