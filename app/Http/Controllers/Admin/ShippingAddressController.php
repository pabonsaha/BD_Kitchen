<?php

namespace App\Http\Controllers;

use App\Models\ShippingAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Support\Facades\Auth;

class ShippingAddressController extends Controller
{
    //

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'shipping_addresses_name' => 'required',
            'shipping_addresses_phone' => 'required',
            'shipping_addresses_street_address' => 'required',
            'shipping_addresses_city' => 'required',
        ]);


        if ($validator->fails()) {

            foreach ($validator->errors()->messages() as $error) {
                Toastr::error($error[0]);
            }
            return redirect()->back();
        }

        try {
            $shipping_address = new ShippingAddress();
            $shipping_address->user_id = Auth::user()->id;
            $shipping_address->name = $request->shipping_addresses_name;
            $shipping_address->phone = $request->shipping_addresses_phone;
            $shipping_address->street_address = $request->shipping_addresses_street_address;
            $shipping_address->state = $request->shipping_addresses_city;
            $shipping_address->created_by = Auth::user()->id;

            $data = ShippingAddress::where('is_default', 1)->get();
            foreach ($data as $shippingAddress) {
                $shippingAddress->is_default = 0;
                $shippingAddress->save();
            }
            $shipping_address->is_default = 1;
            $shipping_address->save();

            Toastr::Success("Shipping Address Created Successfully");

            return redirect()->back();
        } catch (Exception $e) {
            return sendError('Something went wrong');
        }
    }

}
