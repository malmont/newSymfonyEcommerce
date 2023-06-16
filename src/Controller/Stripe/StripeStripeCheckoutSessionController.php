<?php

namespace App\Controller\Stripe;

use Stripe\Stripe;
use App\Entity\Cart;
use Stripe\Checkout\Session;
use App\Services\CartServices;

use App\Services\OrderServices;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StripeStripeCheckoutSessionController extends AbstractController
{
    #[Route('/create-checkout-session/{reference}', name: 'create_checkout_session')]
    public function index(?Cart $cart,OrderServices $orderServices,EntityManagerInterface $manager )
    {
      // $cart = $cartServices->getFullCart();
      if(!$cart){
        return $this->redirectToRoute('app_home');
      }

       $order = $orderServices->createOrder($cart);
       Stripe::setApiKey('sk_test_51MdZibGaPkli494EGcx7ZxIDOS8nhNXcdg6LpW7lZW2JD5T7A6j0QB59pFuBNzbU4r4limwc7pOwkUY9ThDvUCCk00LFaSG55N');
       $checkout_session = Session::create([
          'customer_email' => $this->getUser()->getEmail(),
         'payment_method_types'=>['card'],
         'line_items'=> $orderServices->getLineItems($cart),
          // 'price' => '{{PRICE_ID}}',
        'mode' => 'payment',
        'success_url' => 'https://backend-strapi.online/trt-conseil/',
        'cancel_url' =>  'https://backend-strapi.online/trt-conseil/',
        // 'success_url' => $_ENV['YOUR_DOMAIN] . '/stripe-payment-succes/{CHECKOUT_SESSION_ID}/',
        // 'cancel_url' => $_ENV['YOUR_DOMAIN] . '/stripe_payment_cancel/{CHECKOUT_SESSION_ID}/',
      ]);
    
        $order->setStripeCheckoutSessionId($checkout_session->id);
        $manager->flush();
       return $this->redirect( $checkout_session->url,303);
    }
}
