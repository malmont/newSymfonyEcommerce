<?php

namespace App\Controller\Stripe;

use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Services\CartServices;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StripeStripeCheckoutSessionController extends AbstractController
{
    #[Route('/create-checkout-session', name: 'create_checkout_session')]
    public function index(CartServices $cartServices): JsonResponse
    {
      $cart = $cartServices->getFullCart();
       Stripe::setApiKey('sk_test_51MdZibGaPkli494EGcx7ZxIDOS8nhNXcdg6LpW7lZW2JD5T7A6j0QB59pFuBNzbU4r4limwc7pOwkUY9ThDvUCCk00LFaSG55N');
       $line_items = [];
       foreach ($cart['products'] as $data_product) {
         // [
         //   'quantity' => 5,
         //   'product' =>object
         // ]
         $product = $data_product['product'];
         $line_items[] = [
           'price_data' =>[
             'currency' =>'usd',
             'unit_amount'=>$product->getPrice(),
             'product_data'=>[
               'name'=>$product->getName(),
               'images'=>[$_ENV['YOUR_DOMAIN'].'/uploads/prodcuts/'.$product->getImage()]
             ],
           ],
           'quantity'=> $data_product['quantity']
         ];
       }
       $checkout_session = Session::create([
         'payment_method_types'=>['card'],
         'line_items'=> $line_items,
          // 'price' => '{{PRICE_ID}}',
          'quantity' => 1,
        'mode' => 'payment',
        'success_url' => $_ENV['YOUR_DOMAIN'] . '/stripe-payment-succes',
        'cancel_url' =>  $_ENV['YOUR_DOMAIN']. '/stripe-payment-cancel',
      ]);
    
      
       return $this->json([ "id" =>$checkout_session->id]);
    }
}
