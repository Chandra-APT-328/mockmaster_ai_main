<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stripe
{

    public function __construct(){
        require_once APPPATH.'third_party/stripe-payment/init.php';
    }

    public function create_price($productId, $amount, $currency){
        $stripe = new \Stripe\StripeClient(STRIPE_SECRET_KEY);

        $price = $stripe->prices->create([
            'product' => $productId,
            'unit_amount' => $amount,
            'currency' => $currency,
        ]);
       

        return $price;
    }
    public function checkout($priceId, $quantity){

        try {
            \Stripe\Stripe::setApiKey(STRIPE_SECRET_KEY);
        
            $checkout_session = \Stripe\Checkout\Session::create([
            'line_items' => [[
                'price' => $priceId,
                'quantity' => $quantity,
            ]],
            'mode' => 'payment',
            'success_url' => base_url('package/success/{CHECKOUT_SESSION_ID}'),
            'cancel_url' => base_url('package/cancel'),
            ]);
        
            return $checkout_session->id;
        } catch (\Stripe\Exception\ApiErrorException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    public function paymentstatus($session_id){
       
        $stripe = new \Stripe\StripeClient(STRIPE_SECRET_KEY);
        try {
            $getpaymentDetails = $stripe->checkout->sessions->retrieve($session_id);

            return $getpaymentDetails->payment_status;
         
        } catch (\Stripe\Exception\ApiErrorException $e) {
            echo 'Error: ' . $e->getMessage();
        }
        
    }
}  