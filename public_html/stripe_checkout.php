<?php

session_start();

ini_set('display_errors',1);
error_reporting(E_ALL);

include('../vendor/autoload.php');
include('secrets.php');

\Stripe\Stripe::setApiKey($stripeSecretKey);

$stripe = new \Stripe\StripeClient($stripeSecretKey);

header('Content-Type: application/json');

$YOUR_DOMAIN = 'https://travsavers.com';

$stripe_price =$_SESSION['pricechoice'] * 100;


$cemail = $_SESSION['Email'];

$checkout_session = $stripe->checkout->sessions->create([
 'submit_type' => 'book',
 'ui_mode' => 'embedded',
   'line_items' =>  [
                        [
                           
                         'price_data' => [
                          
                           'unit_amount' => $stripe_price,
                           'currency' => 'usd',
						
							'product_data' => [
                             'name' => 'Payment Amount:',
                             'description' => 'Authorization Only, Final Payment Upon Confirmation'
                           ]
                         ],
                         'quantity' => 1,
                        
                        ],
 
                     ],
  'mode' => 'payment',
'customer_email' => $cemail,
  'return_url' => $YOUR_DOMAIN . '/complete.php?session_id={CHECKOUT_SESSION_ID}',
'payment_intent_data' => [
        'capture_method' => 'manual',
    ],
  'automatic_tax' => [
    'enabled' => false,
  ],
]);
  echo json_encode(array('clientSecret' => $checkout_session->client_secret));

?>