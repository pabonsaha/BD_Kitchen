<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PageDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $items = [];
        if ($this->slug == 'about-us') {
            if (count($this->items) > 0) {
                foreach ($this->items as $item) {
                    $items[] = [
                        'title' => $item->name,
                        'description' => $item->description,
                        'image' => getFilePath($item->image),
                    ];
                }
            }
        }
        if ($this->slug == 'team') {
            if (count($this->items) > 0) {
                foreach ($this->items as $item) {
                    $items[] = [
                        'name' => $item->name,
                        'designation' => $item->description,
                        'image' => getFilePath($item->image),
                    ];
                }
            }
        }

        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'content' => $this->content,
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
            'meta_keywords' => $this->meta_keywords,
            'image' => getFilePath($this->image),
            'items' => $items

        ];
    }
}
