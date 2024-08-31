<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\ShippingAddress;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class CartController extends Controller
{
    //

    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = DB::table('carts')
                ->where('seller_id', getUserId())
                ->join('users', 'carts.user_id', '=', 'users.id')
                ->select('user_id', 'users.name', DB::raw('count(*) as total'))
                ->groupBy('user_id');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $btn = '';
                    if (hasPermission('customer_cart_list_details')) {
                        $btn .= '<a href="' . route('cart.details', $row->user_id) . '" class="btn btn-success text-white" >Details</a>';
                    }
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('cart.index');
    }

    public function details($user_id, Request $request)
    {

        $cart_items = Cart::where('user_id', $user_id)
            ->with('product')
            ->where('seller_id', getUserId())
            ->select('*')->get();

        hasPermissionForOperation($cart_items);

        $shipping_addresses = ShippingAddress::where('user_id',$user_id)->orderBy('id','desc')->get();

        $user = User::find($user_id);

        return view('cart.details', compact('cart_items', 'user','shipping_addresses'));
    }

}
