<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\WishListResource;
use App\Models\Wishlist;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class WishlistController extends Controller
{

    public function list()
    {
        $wishlist = Wishlist::where('user_id', Auth::user()->id)->whereHas('product')->with('product')->paginate(perPage());

        return sendResponse('Wishlist List.', WishListResource::collection($wishlist));
    }

    public function toggle(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id|integer',
        ]);
        if ($validator->fails()) {
            return sendError('Validation Error', $validator->errors(), 403);
        }

        try {

            $wishlist = Wishlist::where('user_id', Auth::user()->id)->where('product_id', $request->product_id)->first();

            if ($wishlist) {
                $wishlist->delete();
                return sendResponse('Remove from wishlist');
            }

            if (!$wishlist) {
                $wishlist = new Wishlist();
                $wishlist->user_id = Auth::user()->id;
                $wishlist->product_id = $request->product_id;
                $wishlist->save();
            }

            return sendResponse('Added to wishlist');
        } catch (Exception $e) {
            return sendError('Something went wrong');
        }
    }
}
