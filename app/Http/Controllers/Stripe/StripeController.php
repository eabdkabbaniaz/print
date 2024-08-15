<?php

namespace App\Http\Controllers\Stripe;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Session;
//use Stripe;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\StripeClient;

class StripeController extends Controller
{
    public function stripe()
    {
        return view('stripe');
    }

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    // public function stripePost(Request $request)
    // {
    //     Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

    //     Stripe\Charge::create ([
    //             "amount" => 100 * 100,
    //             "currency" => "usd",
    //             "description" => "Test payment from raviyatechnical" 
    //     ]);
    private $stripe;
    public function __construct()
    {
        $this->stripe = new StripeClient(env('STRIPE_SECRET'));
        Stripe::setApiKey(env('STRIPE_SECRET'));
    }



    //     return back();
    // }
    // public function createPaymentIntentweb(Request $request)
    // {
    //     Stripe::setApiKey(config('services.stripe.secret'));

    //     $paymentIntent = PaymentIntent::create([
    //         'amount' => 10000,
    //         'currency' => 'usd',
    //         'payment_method_types' => ['card'],
    //     ]);

    //     return response()->json([
    //         'clientSecret' => $paymentIntent->client_secret,
    //     ]);
    // }
    public function createPaymentIntent(Request $request)
    {  try {
        $stripe = new \Stripe\StripeClient('sk_test_51Pj2gJCqliJyryh72Qq101Ri3eXwJOG9a8R1OIUZhkbVWypwhMODRVuDSuFYRKs4fMB16Q4yV8ElrEDA63315nfH00wPsbQq7L');


        $amount = $request->input('amount');
        $customer = $stripe->customers->create();


        $ephemeralKey = $stripe->ephemeralKeys->create([
            'customer' =>  $customer->id,
        ], [
            'stripe_version' => '2024-06-20',
        ]);

        $paymentIntent = $stripe->paymentIntents->create([
            'amount' => $amount,
            'currency' => 'eur',
            'customer' => $customer->id,
            'automatic_payment_methods' => [
                'enabled' => 'true',
            ],
        ]);

        return response()->json([
            'paymentIntent' => $paymentIntent->client_secret,
            'ephemeralKey' => $ephemeralKey->secret,
            'customer' => $customer->id,
            'publishableKey' => 'pk_test_51Pj2gJCqliJyryh7uf46ge828e0y86eQPKmU7pQVaT8x0H0u6R5mccpQgaQ1g9QdH1DIx9KGivdurMlC5Uvc9XIN00DvGnnVKA'
        ], 200);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
    }


    public function createPaymentIntentweb(Request $request)
    {
        $stripe = new \Stripe\StripeClient('sk_test_51Pj2gJCqliJyryh72Qq101Ri3eXwJOG9a8R1OIUZhkbVWypwhMODRVuDSuFYRKs4fMB16Q4yV8ElrEDA63315nfH00wPsbQq7L');
        $checkout_session = $stripe->checkout->sessions->create([
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => 'T-shirt',
                    ],
                    'unit_amount' => 100000 * 10,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => 'http://localhost:8000/success',
            'cancel_url' => 'http://localhost:4242/cancel',
        ]);
        return Redirect($checkout_session->url);
    }
}
