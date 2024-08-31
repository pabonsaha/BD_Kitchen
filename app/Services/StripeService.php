<?php

namespace App\Services;

use App\Models\GatewayCredentials;
use App\Models\PaymentMethodStatus;
use App\Models\SubscriptionPaymentLog;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;
use Stripe\Subscription;

class StripeService
{

    public function makeOrderPayment($order, $success_url, $cancel_url)
    {
        if (globalSetting('stripe')->value == 1) { //check if stripe is enable globally

            $payment_status = $this->checkIfStripeIsSetup($order->seller_id);
            $secret_key = $this->getStripeCredential($order->seller_id);
            if ($payment_status) {
                Stripe::setApiKey($secret_key);
                $unitAmount = $this->calculatePrice($order->grand_total_amount);

                // Define the product and price details
                $lineItems = $this->createOrderPaymentPayload($order->code, $unitAmount);

                // Create the Checkout Session
                $checkoutSession = StripeSession::create([
                    'payment_method_types' => ['card', 'link'],
                    'line_items' => $lineItems,
                    'mode' => 'payment',
                    'success_url' => $success_url . '?session_id={CHECKOUT_SESSION_ID}&order_id=' . $order->id,
                    'cancel_url' => $cancel_url,
                ]);

                return $checkoutSession->url;
            }
        }
        return false;
    }

    public function makeSubscriptionPlanPayment($plan, $success_url, $cancel_url)
    {
        if (globalSetting('stripe')->value == 1) {


            $user = User::find(auth()->user()->id);

            $secret_key = $this->getStripeCredential(1);
            Stripe::setApiKey($secret_key);

            if (!$user->stripe_id) {
                // Create a new Stripe customer
                $customer = \Stripe\Customer::create([
                    'email' => $user->email,
                    'name' => $user->name,
                ]);

                $user->stripe_id = $customer->id;
                $user->save();
            } else {
                // Retrieve existing customer
                $customer = \Stripe\Customer::retrieve($user->stripe_id);
            }


            $subsciptionItem = $this->createSubscriptionPaymentPayload($plan);
            $session = StripeSession::create([
                'customer' => $user->stripe_id,
                'payment_method_types' => ['card', 'link'],
                'success_url' => $success_url,
                'cancel_url' =>  $cancel_url,
                'mode' => 'subscription',
                'line_items' => $subsciptionItem,
            ]);


            return $session->url;
        }
        return false;
    }

    public function checkIfUserHasActiveSubscription($user, $plan)
    {
        $subscriptions = \Stripe\Subscription::all([
            'customer' => $user->stripe_id,
            'status' => 'active',
        ]);

        // Check if the user already has the subscription
        $hasActiveSubscription = false;
        foreach ($subscriptions->data as $subscription) {
            foreach ($subscription->items->data as $item) {
                if ($item->price->id == $plan->price_id) {
                    $hasActiveSubscription = true;
                    break;
                }
            }
            if ($hasActiveSubscription) {
                break;
            }
        }

        if ($hasActiveSubscription) {
            // Notify the user they already have an active subscription
            echo "You already have an active subscription to this plan.";
        } else {
            // Proceed to create a new subscription session
            $session = \Stripe\Checkout\Session::create([
                // Session creation code here...
            ]);
        }
    }

    public function createSubscriptionPaymentPayload($plan)
    {
        $planList = [
            [
                'price' => $plan->price_id,
                'quantity' => 1,
            ],
        ];
        $subscriptionPaymentLog = SubscriptionPaymentLog::where('user_id', Auth::user()->id)->get();

        if ($subscriptionPaymentLog->isEmpty()) {
            $onetimefee = [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => 'One-time Setup Fee',
                    ],
                    'unit_amount' => $plan->setup_fee * 100 ?? 0,
                ],
                'quantity' => 1,
            ];
            array_push($planList, $onetimefee);
        }
        return $planList;
    }

    public function createOrderPaymentPayload($order_code, $amount, $quantity = 1)
    {
        return [[
            'price_data' => [
                'currency' => 'usd',
                'product_data' => [
                    'name' => $order_code,
                ],
                'unit_amount' => $amount, // Amount in cents
            ],
            'quantity' => $quantity,
        ]];
    }

    public function calculatePrice($amount)
    {

        return intval($amount * 100);
    }

    public function getStripeCredential($id)
    {
        $gatewayCredential = GatewayCredentials::where('payment_method_id', 1)->where('key', 'secret_key')->where('user_id', $id)->first();

        return $gatewayCredential->value;
    }

    public function checkIfStripeIsSetup($id)
    {
        $status = PaymentMethodStatus::where('user_id', $id)->where('payment_method_id', 1)->where('active_status', 1)->where('setup_status', 1)->first();
        if ($status) {
            return true;
        }
        return false;
    }


    public function successPayment($sessionId, $order_id)
    {
        $session = StripeSession::retrieve($sessionId);

        // Access session data
        $paymentIntentId = $session->payment_intent;
        $amountTotal = $session->amount_total;
        $currency = $session->currency;
        $customer_details = $session->customer_details;
        $payment_status = $session->payment_status;
        $created = $session->created;

        $payment_details = [
            'payment_intent_id' => $paymentIntentId,
            'amount_total' => $amountTotal,
            'currency' => $currency,
            'customer_details' => [
                'name' => $customer_details->name,
                'email' => $customer_details->email,
            ],
            'payment_status' => $payment_status,
            'created' => date('Y-m-d H:i:s', $created),
            'order_id' => $order_id,
        ];

        return [
            'payment_status' => $payment_status,
            'payment_details' => $payment_details,
        ];
    }

    public function generateInvoice($invoice_no)
    {

        $secret_key = $this->getStripeCredential(1);
        Stripe::setApiKey($secret_key);
        $invoice = \Stripe\Invoice::retrieve($invoice_no);
        return $invoice;
    }

    public function cancelSubscriptonImmediately($currentActiveSubscripton)
    {
        $secret_key = $this->getStripeCredential(1);
        Stripe::setApiKey($secret_key);
        $subscription = Subscription::retrieve($currentActiveSubscripton->subscription_no, [])->cancel();

        return $subscription;
    }

    public function cancelSubscriptonRevoke($currentActiveSubscripton)
    {
        $secret_key = $this->getStripeCredential(1);
        Stripe::setApiKey($secret_key);
        $subscription = Subscription::update($currentActiveSubscripton->subscription_no, [
            'cancel_at_period_end' => true,
        ]);
        return $subscription;
    }
}
