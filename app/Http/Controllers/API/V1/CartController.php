<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use App\Models\ShopSetting;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{


    public function index(Request $request)
    {
        $cart = Cart::where('user_id', Auth::user()->id)
            // ->where('designer_id', getDesignerID())
            ->with('product')
            ->get();
        return sendResponse('Cart List', CartResource::collection($cart));
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
            $cart = Cart::where('user_id', Auth::user()->id)
                ->where('seller_id', getSellerIdByProductId($request->product_id))
                ->where('product_id', $request->product_id)
                ->where('variation_id', $request->variation_id)
                ->first();

            if (!$cart) {
                $cart = new Cart();
                $cart->seller_id = getSellerIdByProductId($request->product_id);
                $cart->user_id = Auth::user()->id;
                $cart->product_id = $request->product_id;
                $cart->variation_id = $request->variation_id;
                $cart->variation = json_decode($request->variation) ?? [];
                $cart->price = $request->price;
            }

            $cart->quantity += $request->quantity;

            $cart->save();

            return sendResponse('Cart Updated Successfully');
        } catch (Exception $e) {
            return sendError('Something went wrong');
        }
    }

    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cart_id' => 'required|exists:carts,id|integer',
        ]);

        if ($validator->fails()) {
            return sendError('Validation Error', $validator->errors(), 403);
        }
        try {
            Cart::where('id', $request->cart_id)->delete();

            return sendResponse('Product Deleted from cart list');
        } catch (Exception $e) {
            return sendError('Something went wrong');
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cart_id' => 'required|array',
            'cart_id.*' => 'required|exists:carts,id|integer',
            'quantity' => 'required|array',
            "quantity.*"  => "required|int|min:1",
        ]);

        if ($validator->fails()) {
            return sendError('Validation Error', $validator->errors(), 403);
        }

        try {
            foreach ($request->cart_id as $key => $cart_id) {
                $cart = Cart::find($cart_id);
                if ($cart) {
                    $cart->quantity = $request->quantity[$key];
                    $cart->save();
                }
            }
            return sendResponse('Cart Updated Successfully');
        } catch (Exception $e) {
            return sendError('Something went wrong');
        }
    }
}
