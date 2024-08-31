<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\AttributeResource;
use App\Http\Resources\BrandResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductListResource;
use App\Http\Resources\ProductResource;
use App\Models\Attribute;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{



    public function list(Request $request)
    {
        $validated = $request->validate([
            'categories' => 'array',
            'categories.*' => 'integer',
            'priceFrom' => 'integer',
            'priceTo' => 'integer',
            'attribute' => 'json',
            'sort_by' => 'string|in:a-z,z-a,low-high,high-low,old-new,new-old',
        ]);

        $products = Product::where('is_published', 1)
            ->withCount('wishlist')
            ->whereIn('user_id', getSellerIds())
            ->with('category');

        if ($request->has('categories')) {
            $products = $products->whereIn('category_id', $request->categories);
        }

        if ($request->has('priceFrom')) {
            $products = $products->where('unit_price', '>=', $request->priceFrom);
        }
        if ($request->has('priceTo')) {
            $products = $products->where('unit_price', '<=', $request->priceTo);
        }
        if ($request->has('search')) {
            $products = $products->where('name','like','%'.$request->search.'%');
        }

        if ($request->has('attribute')) {
            $attributes = json_decode($request->attribute, true);
            $validator = Validator::make($attributes, [
                '*.id'    => 'required|integer',
                '*.value' => 'required|array',
            ]);
            if ($validator->fails()) {
                return sendError('Attribute Validation error', $validator->errors());
            }

            $products = $products->where(function ($query) use ($attributes) {
                foreach ($attributes as $attribute) {
                    $query = $query->whereJsonContains('choice_options', ['attribute_id' => $attribute['id'], 'value' => $attribute['value']]);
                }
            });
        }

        if ($request->has('sort_by')) {
            $products = match ($request->sort_by) {
                'a-z' => $products->orderBy('name', 'asc'),
                'z-a' => $products->orderBy('name', 'desc'),
                'low-high' => $products->orderBy('unit_price', 'asc'),
                'high-low' => $products->orderBy('unit_price', 'desc'),
                'old-new' => $products->orderBy('created_at', 'asc'),
                'new-old' => $products->orderBy('created_at', 'desc'),
                default => $products->orderByDesc('id'),
            };
        } else {
            $products = $products->orderByDesc('id');
        }

        $products = $products->paginate(perPage());

        return sendResponse('All products list.', ProductListResource::collection($products)->resource);
    }


    public function details(Product $product)
    {
        if ($product->is_published == 1) {
            $product = $product->load(['images', 'choiceOptions.values', 'variants', 'category', 'brand'])->loadCount('wishlist');
            return sendResponse('Product details.', new ProductResource($product));
        }
        $product = collect([]);
        return sendError('Product not avaiable.');
    }

    public function filterItems()
    {
        $attibutes = Attribute::with('values')->whereHas('values')->where('status', 1)->get();
        $categories = Category::where('active_status', 1)->get();
        $price = DB::table('products')
            ->select(DB::raw('MIN(unit_price) AS minPrice, MAX(unit_price) AS maxPrice'))
            ->first();

        $data[] = [
            'name' => 'Price Range',
            'list' => [
                "minPrice" => floor($price->minPrice),
                "maxPrice" => ceil($price->maxPrice),
            ],
        ];

        $data[] = [
            'name' => 'Categories',
            'list' => CategoryResource::collection($categories),
        ];

        $data[] = [
            'name' => 'Attributes',
            'list' => AttributeResource::collection($attibutes),
        ];


        return sendResponse('All Attribute list with values.', $data);
    }

    public function relatedProducts(Product $product)
    {
        try {

            if ($product->is_published == 1) {
                $relatedProducts = Product::where('category_id', $product->category_id)
                    ->where('id', '!=', $product->id)
                    ->whereIn('user_id', getSellerIds())
                    ->where('is_published', 1)
                    ->latest()
                    ->take(4)
                    ->with('category')
                    ->get();

                if ($relatedProducts->isNotEmpty()) {
                    return sendResponse('Related products.', ProductListResource::collection($relatedProducts));
                }
            }
            return sendError('Related products not available.');
        } catch (\Exception $e) {
            return sendError('Something went wrong.');
        }
    }
}
