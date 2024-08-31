<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Product;
use Illuminate\Http\Request;

class DevController extends Controller
{
    // productAdminToManufac
    public function productAdminToManufac()
    {
        $product = Product::where('user_id', 1)->update(['user_id' => Role::MANUFACTURER]);
        return response()->json($product);
    }
}
