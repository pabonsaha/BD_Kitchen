<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Illuminate\Support\Str;

class ProductsImport implements ToModel, WithHeadingRow, WithValidation
{
    use Importable, SkipsFailures;

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $new_tag = str_replace(' ', '', $row['tags']);
        $new_tag = explode(",", $new_tag);

        return new Product([
            'name' => $row['name'],
            'user_id' => getUserId(),
            'slug' => Str::slug($row['name']).md5(uniqid(rand(), true)),
            'category_id' => $row['category_id'],
            'brand_id' => $row['brand_id'],
            'video_link' => $row['video_link'],
            'tags' => json_encode($new_tag),
            'description' => $row['description'],
            'unit_price' => $row['unit_price'],
            'shipping_policy' => $row['shipping_policy'],
            'return_policy' => $row['return_policy'],
            'disclaimer' => $row['disclaimer'],
            'discount_type' => $row['discount_type'],
            'discount' => $row['discount'],
            'meta_title' => $row['meta_title'],
            'meta_description' => $row['meta_description'],
            'is_published' => $row['is_published'],
            'attributes' => [],
            'choice_options' => [],
            'weight_dimensions' => [],
            'specifications' => [],

        ]);
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'shipping_policy' => 'nullable',
            'return_policy' => 'nullable',
            'disclaimer' => 'nullable',
            'unit_price' => 'required|numeric',
            'discount_type' => 'required|in:0,1,2',
            'discount' => 'required_if:discount_type,1,2',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'is_published' => 'required|in:1,0',
        ];
    }
}
