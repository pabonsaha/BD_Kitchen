<?php

namespace App\Exports;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return new Collection([

        ]);
    }

    public function headings(): array
    {
        return [
            'name',
            'description',
            'unit_price',
            'discount_type',
            'discount',
            'category_id',
            'brand_id',
            'video_link',
            'shipping_policy',
            'return_policy',
            'disclaimer',
            'meta_title',
            'meta_description',
            'tags',
            'is_published',
        ];
    }

}
