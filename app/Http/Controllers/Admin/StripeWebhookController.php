<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\SubscriptionPaymentLog;
use App\Models\User;
use App\Services\StripeService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StripeWebhookController extends Controller
{
    //

    public function handleWebhook()
    {

        // Set your secret key. Remember to switch to your live secret key in production.
        // See your keys here: https://dashboard.stripe.com/apikeys
        $stripe = new StripeService();
        $secret_key = $stripe->getStripeCredential(1);
        \Stripe\Stripe::setApiKey($secret_key);

        // If you are testing your webhook locally with the Stripe CLI you
        // can find the endpoint's secret by running `stripe listen`
        // Otherwise, find your endpoint's secret in your webhook settings in the Developer Dashboard
        $endpoint_secret = 'whsec_OJLzRPFZ3mJyAeoCmlKxj70ESwSi0IDy';

        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $event = null;

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload,
                $sig_header,
                $endpoint_secret
            );
        } catch (\UnexpectedValueException $e) {
            // Invalid payload
            http_response_code(400);
            echo json_encode(['Error parsing payload: ' => $e->getMessage()]);
            exit();
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            http_response_code(400);
            echo json_encode(['Error verifying webhook signature: ' => $e->getMessage()]);
            exit();
        }

        // Handle the event
        return match ($event->type) {
            'invoice.payment_succeeded' => $this->storePaymentLog($event->data->object),
            'customer.subscription.deleted' => $this->deleteSubscription($event->data->object),
            default => 'Received unknown event type ' . $event->type,
        };


        http_response_code(200);
    }


    public function storePaymentLog($object)
    {
        try {
            DB::beginTransaction();

            $user = User::where('stripe_id', $object->customer)->first();
            foreach ($object->lines->data as $item) {
                $plan = null;
                if ($item->plan) {
                    $plan = Plan::where('price_id', $item->plan->id)->first();
                }

                if ($plan) {
                    $subscriptionLog = new SubscriptionPaymentLog();
                    $subscriptionLog->user_id = $user->id;
                    $subscriptionLog->plan_id = $plan->id;
                    $subscriptionLog->price = $object->amount_paid;
                    $subscriptionLog->customer_details = json_encode([
                        'name' => $object->customer_name,
                        'email' => $object->customer_email,
                        'phone' => $object->customer_phone,
                    ]);
                    $subscriptionLog->created =  $item->period->start;
                    $subscriptionLog->expire_at = $item->period->end;
                    $subscriptionLog->invoice_no = $object->id;
                    $subscriptionLog->payment_status = $object->status;
                    $subscriptionLog->subscription_no = $object->subscription;
                    $subscriptionLog->customer_id = $object->customer;
                    $subscriptionLog->currency = $object->currency;
                    $subscriptionLog->save();

                    $user->is_subscribed = 1;
                    $user->save();
                }
            }
            DB::commit();
            return sendResponse("Payment successfull");
        } catch (Exception $e) {
            return $e;
            DB::rollBack();
        }
    }

    public function deleteSubscription($object)
    {
        try {
            DB::beginTransaction();

            $paymentLog = SubscriptionPaymentLog::where('subscription_no', $object->id)
                ->update(['payment_status' => $object->status]);
            $user = User::where('stripe_id', $object->customer)->first();
            $user->is_subscribed = 0;
            $user->save();
            DB::commit();

            return sendResponse("Subscritption Cancel successfull");
        } catch (Exception $e) {
            return $e;
            DB::rollBack();
        }
    }
}
