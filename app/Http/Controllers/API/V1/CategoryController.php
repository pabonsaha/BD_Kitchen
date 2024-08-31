<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // index
    public function list()
    {
        $categories = CategoryResource::collection(Category::withCount(['products' => function ($q) {
            $q->whereIn('user_id', getSellerIds())->where('is_published', 1);
        }])
            ->having('products_count', '>', 0)
            ->where('active_status', 1)
            ->paginate(perPage()))
            ->resource;

        $border_shape = globalSetting('category_design')->value == 0 ? json_decode(globalSetting('category_design')->options)[0] : json_decode(globalSetting('category_design')->options)[1];

        return sendResponse('All category list.', ['categories' => $categories, 'category_design' => $border_shape]);
    }

    public function categoryWithProduct()
    {
        $categories = Category::where('active_status', 1)
            ->whereHas('products', function ($q) {
                $q->whereIn('user_id', getSellerIds())
                    ->where('is_published', 1);
            })
            ->with('products', function ($q) {
                $q->whereIn('user_id', getSellerIds())
                    ->where('is_published', 1);
            })
            ->paginate(perPage());
        return sendResponse('All category list with products.', CategoryResource::collection($categories)->resource);
    }
}
