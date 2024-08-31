<?php

namespace App\Http\Controllers\API\V1;

use Exception;
use Stripe\Stripe;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use App\Services\StripeService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\SubscriptionPaymentLog;
use Illuminate\Support\Facades\Validator;
use Stripe\Checkout\Session as StripeSession;
use App\Http\Resources\SubscriptionPlanResource;

class SubscriptionController extends Controller
{

    public function index($planFor = null)
    {
        try {
            $query = Plan::where('is_active', 1);

            if ($planFor !== null) {
                $planId = match ($planFor) {
                    'designer' => 3,
                    'manufacturer' => 5,
                    default => null
                };

                $query->where('role_id', $planId);
            }

            $data = $query->get();

            $message = match ($planFor) {
                'designer' => "Plan For Designer.",
                'manufacturer' => "Plan For Manufacturer.",
                default => "Plans.",
            };

            return sendResponse($message, SubscriptionPlanResource::collection($data));
        } catch (Exception $e) {
            return sendError('Something went wrong!');
        }
    }

    public function details($id)
    {
        try {
            $plan = Plan::find($id);
            if ($plan) {
                return sendResponse("Plan Details", new SubscriptionPlanResource($plan));
            }
            return sendError('Plan not found!');
        } catch (Exception $e) {
            return sendError("Something went wrong!");
        }
    }

    public function makePayment(Request $request)
    {
        $request->validate([
            'plan_id' => 'required|exists:plans,id',
            'success_url' => 'required',
            'cancel_url' => 'required',
        ]);

        try {
            $plan = Plan::find($request->plan_id);
            if ($plan) {
                $stripeService = new StripeService();
                $data = $stripeService->makeSubscriptionPlanPayment($plan, $request->success_url, $request->cancel_url);
                return sendResponse("Checkout Url.", $data);
            }
            return sendError('Plan not found!');
        } catch (Exception $e) {
            return $e;
            return sendResponse("Something went wrong!");
        }
    }


    // paymentMethods
    public function paymentMethods()
    {
        try {
            $paymentMethods = PaymentMethod::all();

            $stripeEnabled = globalSetting('stripe')->value == 1;
            $paypalEnabled = globalSetting('paypal')->value == 1;

            $filteredPaymentMethods = $paymentMethods->filter(function ($paymentMethod) use ($stripeEnabled, $paypalEnabled) {
                if ($paymentMethod->id == 1 && $stripeEnabled) {
                    return true;
                }
                if ($paymentMethod->id == 2 && $paypalEnabled) {
                    return true;
                }
                return false;
            })->map(function ($paymentMethod) {
                return [
                    'id' => $paymentMethod->id,
                    'name' => $paymentMethod->name,
                    'logo' => asset($paymentMethod->logo),
                ];
            });

            return sendResponse('Payment Methods', $filteredPaymentMethods);
        } catch (Exception $e) {
            return sendError('Something went wrong');
        }
    }
}
