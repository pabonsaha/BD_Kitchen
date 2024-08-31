<?php

namespace App\Http\Controllers;

use App\Exports\ProductBulkExport;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Role;
use App\Models\User;

use Brian2694\Toastr\Facades\Toastr;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class BulkExportController extends Controller
{

    public function index()
    {
        try {

            $categories = Category::where('active_status', 1)->get();
            $brands = Brand::where('active_status', 1)->get();
            $designers = User::where('role_id', Role::DESIGNER)->get();
            $manufacturers = User::where('role_id', Role::MANUFACTURER)->get();
            return view('bulk-import.product-export', compact('categories', 'brands', 'designers', 'manufacturers'));
        }catch (\Exception $exception){
            Toastr::error($exception->getMessage());
        }
    }

    public function export(Request $request)
    {
        try {
            $products = Product::where('user_id', getUserId());

            if ($request->filled('isPublishedList')) {
                $products->where('is_published', $request->isPublishedList);
            }

            if ($request->filled('categoryList')) {
                $products->where('category_id', $request->categoryList);
            }

            if ($request->filled('brandList')) {
                $products->where('brand_id', $request->brandList);
            }

            if ($request->filled('manufacturerList')) {
                $products->where('vendor_id', $request->manufacturerList);
            }

            if ($request->filled('designerList')) {
                $products->where('vendor_id', $request->designerList);
            }


            $products = $products->get();

            return Excel::download(new ProductBulkExport($products), 'products.xlsx');
        }catch (\Exception $exception){
            Toastr::error($exception->getMessage());
        }

    }
}
