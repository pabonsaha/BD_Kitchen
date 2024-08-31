<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductRequestResource;
use App\Models\ProductRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProductRequestController extends Controller
{

    public function index()
    {
        $productRequest = ProductRequest::where('user_id', Auth::user()->id)
            ->with('product')
            ->get();
        return sendResponse('Product request List', ProductRequestResource::collection($productRequest));
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'product_id' => 'required|exists:products,id|integer',
            'designer' => 'sometimes|exists:shop_settings,slug',
            'variation' => 'sometimes|json',
        ]);

        if ($validator->fails()) {
            return sendError('Validation Error', $validator->errors(), 403);
        }

        try {
            $productRequest = ProductRequest::where('user_id', Auth::user()->id)
                ->where('seller_id', getSellerIdByProductId($request->product_id))
                ->where('product_id', $request->product_id)
                ->where('variation_id', $request->variation_id)
                ->first();



            if (!$productRequest) {
                $productRequest = new ProductRequest();
                $productRequest->seller_id = getSellerIdByProductId($request->product_id);
                $productRequest->user_id = Auth::user()->id;
                $productRequest->product_id = $request->product_id;
                $productRequest->variation_id = $request->variation_id;
                $productRequest->variation = json_decode($request->variation) ?? [];
                $productRequest->price = $request->price;
            }

            $productRequest->quantity += $request->quantity;

            $productRequest->save();

            return sendResponse('Product has been requested');
        } catch (Exception $e) {
            return $e;
            return sendError('Something went wrong');
        }
    }
}
