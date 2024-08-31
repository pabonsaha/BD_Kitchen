<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\ProductRequest;
use App\Models\Role;
use App\Models\ShippingAddress;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ProductRequestController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = ProductRequest::with('user', 'product')->get();

            $data = match (Auth::user()->role_id) {
                Role::DESIGNER => $data->where('designer_id', Auth::user()->id),
                Role::MANUFACTURER => $data->where('seller_id', Auth::user()->id),
                default => $data,
            };

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('product_name', function ($row) {
                    return '<img src="' . getFilePath($row->product->thumbnail_img) . '" width="50px" height="50px"/>' . $row->product->name;
                })
                ->editColumn('price', function ($row) {
                    return getPriceFormat($row->price);
                })
                ->addColumn('action', function ($row) {
                    $btn = '';
                    if ($row->getRawOriginal('status') == 0) {
                        if (hasPermission('customer_order_product_request_approve')) {
                            $btn .= '<a href="#" class="btn btn-success text-white product_request_approve_button" data-id="' . $row->id . '">Approve</a>';
                        }
                        if (hasPermission('customer_order_product_request_cancel')) {
                            $btn .= '<a href="#" class="btn btn-danger text-white ms-2 product_request_cancel_button" data-id="' . $row->id . '">Cancel</a>';
                        }
                    }
                    if ($row->getRawOriginal('status') == 1) {
                        if (hasPermission('customer_order_product_request_add_to_cart')) {
                            $btn .= '<a href="#" class="btn btn-warning text-white ms-2 product_request_cart_button" data-id="' . $row->id . '">Add to cart</a>';
                        }
                    }
                    if ($row->getRawOriginal('status') == 2) {
                        $btn .= '<a href="#" class="btn btn-danger text-white ms-2" >Canceled</a>';
                    }


                    return $btn;
                })
                ->rawColumns(['action', 'product_name'])
                ->make(true);
        }
        return view('product-request.index');
    }

    public function details($user_id, Request $request)
    {

        $cart_items = ProductRequest::where('user_id', $user_id)
            ->with('product')
            ->select('*')->get();

        hasPermissionForOperation($cart_items);

        $shipping_addresses = ShippingAddress::where('user_id', $user_id)->orderBy('id', 'desc')->get();

        $user = User::find($user_id);

        return view('product-request.details', compact('cart_items', 'user', 'shipping_addresses'));
    }

    public function approve(Request $request)
    {
        try {
            $productRequest = ProductRequest::find($request->product_request_id);

            $productRequest->status = 1;

            $productRequest->save();
            return response()->json(['text' => 'Product Request Approved.', 'icon' => 'success']);
        } catch (Exception $e) {
            return response()->json(['text' => "Something went wrong"]);
        }
    }
    public function cancel(Request $request)
    {
        try {
            $productRequest = ProductRequest::find($request->product_request_id);

            $productRequest->status = 2;

            $productRequest->save();
            return response()->json(['text' => 'Product Request Canceled.', 'icon' => 'success']);
        } catch (Exception $e) {
            return response()->json(['text' => "Something went wrong"]);
        }
    }

    public function addToCart(Request $request)
    {
        $cart  = new Cart();

        $cart->save();
    }
}
