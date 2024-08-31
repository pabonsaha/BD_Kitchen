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
            'modalAddressFullName' => 'required',
            'modalAddressPhone' => 'required',
            'modalAddressEmail' => 'required|email',
            'modalAddressStreet' => 'required',
            'modalAddressState' => 'required',
            'modalAddressCountry' => 'required',
            'modalUserID' => 'required',
        ]);


        if ($validator->fails()) {

            foreach ($validator->errors()->messages() as $error) {
                Toastr::error($error[0]);
            }
            return redirect()->back();
        }

        try {
            $shipping_address = new ShippingAddress();
            $shipping_address->user_id = $request->modalUserID;
            $shipping_address->name = $request->modalAddressFullName;
            $shipping_address->email = $request->modalAddressEmail;
            $shipping_address->phone = $request->modalAddressPhone;
            $shipping_address->country = $request->modalAddressCountry;
            $shipping_address->state = $request->modalAddressState;
            $shipping_address->street_address = $request->modalAddressStreet;
            $shipping_address->zip_code = $request->modalAddressZipCode;
            $shipping_address->created_by = Auth::user()->id;

            $data = ShippingAddress::where('is_default', 1)->get();
            foreach ($data as $shippingAddress) {
                $shippingAddress->is_default = 0;
                $shippingAddress->save();
            }
            $shipping_address->is_default = 1;
            $shipping_address->save();

            Toastr::Success("Shipping Address Successfully");

            return redirect()->back();
        } catch (Exception $e) {
            return sendError('Something went wrong');
        }
    }
}
