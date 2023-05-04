<?php

namespace App\Controller\Stripe;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StripeStripeSuccesPaymentController extends AbstractController
{
    #[Route('/stripe-payment-succes', name: 'stripe_payment_succes')]
    public function index(): Response
    {
        return $this->render('stripe_stripe_succes_payment/index.html.twig', [
            'controller_name' => 'StripeStripeSuccesPaymentController',
        ]);
    }
}
