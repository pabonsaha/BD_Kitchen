<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShopSettingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'shop_name' =>$this->shop_name,
            'slug' =>$this->slug,
            'logo' =>asset(getFilePath($this->logo)),
            'favicon' =>asset(getFilePath($this->favicon)),
            'banner' =>asset(getFilePath($this->banner)),
            'location' =>$this->location,
            'map_location' =>$this->map_location,
            'phone' =>$this->phone,
            'email' =>$this->email,
            'instagram_url' => $this->instagram_url,
            'tiktok_url' => $this->tiktok_url,
            'facebook_url' => $this->facebook_url,
            'youtube_url' => $this->youtube_url,
            'linkedin' => $this->linkedin,
            'twitter_url' => $this->twitter_url,
        ];
    }
}
