<?php

namespace App\Controller\Stripe;

use App\Entity\Order;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StripeStripeCancelPaymentController extends AbstractController
{
    #[Route('/stripe-payment-cancel/{StripeCheckoutSessionId}', name: 'stripe_payment_cancel')]
    public function index(?Order $order): Response
    {
        if(!$order || $order->getUserOrder() !== $this->getUser()){
            return $this->redirectToRoute('app_home');
        }

        return $this->render('stripe_stripe_cancel_payment/index.html.twig', [
            'controller_name' => 'StripeStripeCancelPaymentController',
            'order'=>$order
        ]);
    }
}
