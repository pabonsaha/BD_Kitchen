<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ColorThemeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'colors' => [
                'primary_color'     => $this->primary_color,
                'secondary_color'   => $this->secondary_color,
                'background_color'  => $this->background_color,
                'button_bg_color'   => $this->button_bg_color,
                'button_text_color' => $this->button_text_color,
                'hover_color'       => $this->hover_color,
                'border_color'      => $this->border_color,
                'text_color'        => $this->text_color,
                'secondary_text_color'=> $this->secondary_text_color,
                'shadow_color'      => $this->shadow_color,
                'sidebar_bg'        => $this->sidebar_bg,
                'sidebar_hover'     => $this->sidebar_hover,
            ],
        ];
    }

}
