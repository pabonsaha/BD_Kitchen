<?php

namespace App\Http\Controllers;

use App\Http\Traits\FileUploadTrait;
use App\Models\GatewayCredentials;
use App\Models\PaymentMethod;
use App\Models\PaymentMethodStatus;
use App\Models\Role;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class PaymentMethodController extends Controller
{
    use FileUploadTrait;

    public function index(Request $request)
    {
        $methods = PaymentMethod::all();
        return view('setting.payment-method.index',compact('methods'));
    }

    public function stripeCredentialStore(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'public_key' => 'required',
            'secret_key' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'status' => 403], 200);
        }

        try {

            PaymentMethodStatus::updateOrCreate([
                'user_id'   => getUserId(),
                'payment_method_id' => 1,
            ], [
                'setup_status'     => 1,
            ]);

            GatewayCredentials::updateOrCreate([
                'user_id'   => getUserId(),
                'payment_method_id' => 1,
                'key'     => 'public_key',
            ], [
                'value'     => $request->public_key,
            ]);
            GatewayCredentials::updateOrCreate([
                'user_id'   => getUserId(),
                'payment_method_id' => 1,
                'key'     => 'secret_key',
            ], [
                'value'     => $request->secret_key,
            ]);

            return response()->json(['message' => 'Stripe Creadential Updated', 'status' => 200], 200);
        } catch (Exception $e) {
            return $e;
            return response()->json(['message' => 'Something went wrong', 'status' => 500], 500);
        }
        return back();
    }
    public function paypalCredentialStore(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'client_id' => 'required',
            'client_secret' => 'required',
            'paypal_mode_input' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'status' => 403], 200);
        }

        try {
            DB::beginTransaction();

            PaymentMethodStatus::updateOrCreate([
                'user_id'   => getUserId(),
                'payment_method_id' => 2,
            ], [
                'setup_status'     => 1,
            ]);

            GatewayCredentials::updateOrCreate([
                'user_id'   => getUserId(),
                'payment_method_id' => 2,
                'key'     => 'client_id',
            ], [
                'value'     => $request->client_id,
            ]);
            GatewayCredentials::updateOrCreate([
                'user_id'   => getUserId(),
                'payment_method_id' => 2,
                'key'     => 'client_secret',
            ], [
                'value'     => $request->client_secret,
            ]);
            GatewayCredentials::updateOrCreate([
                'user_id'   => getUserId(),
                'payment_method_id' => 2,
                'key'     => 'mode',
            ], [
                'value'     => $request->paypal_mode_input == 'true' ? 1 : 0,
            ]);
            DB::commit();

            return response()->json(['message' => 'Paypal Creadential Updated', 'status' => 200], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Something went wrong', 'status' => 500], 500);
        }
        return back();
    }

    public function stripeChangeStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'status' => 403], 200);
        }

        try {

            PaymentMethodStatus::updateOrCreate([
                'user_id'   => getUserId(),
                'payment_method_id' => 1,
            ], [
                'active_status'     => $request->status == 'true' ? 1 : 0,
            ]);

            return response()->json(['message' => 'Stripe Status Updated Successfully', 'status' => 200], 200);
        } catch (\Exception $e) {
            return $e;
            return response()->json(['message' => "Something went Wrong!"], 500);
        }
    }
    public function paypalChangeStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'status' => 403], 200);
        }

        try {

            PaymentMethodStatus::updateOrCreate([
                'user_id'   => getUserId(),
                'payment_method_id' => 2,
            ], [
                'active_status'     => $request->status == 'true' ? 1 : 0,
            ]);

            return response()->json(['message' => 'Paypal Status Updated Successfully', 'status' => 200], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => "Something went Wrong!"], 500);
        }
    }
}
