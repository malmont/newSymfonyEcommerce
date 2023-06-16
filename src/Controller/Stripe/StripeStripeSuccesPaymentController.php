<?php

namespace App\Controller\Stripe;

use App\Entity\Order;
use App\Services\CartServices;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StripeStripeSuccesPaymentController extends AbstractController
{
    #[Route('/stripe-payment-succes/{StripeCheckoutSessionId}', name: 'stripe_payment_succes')]
    public function index(?Order $order, CartServices  $cartServices , EntityManagerInterface $manager): Response
    {
        if(!$order || $order->getUserOrder() !== $this->getUser()){
            return $this->redirectToRoute('app_home');
        }
        if(!$order->getIspaid()){
            $order->setIspaid(true);
            $manager->flush();
            $cartServices->deleteCart();
          
        }
        return $this->render('stripe_stripe_succes_payment/index.html.twig', [
            'controller_name' => 'StripeStripeSuccesPaymentController',
            'order'=>$order
        ]);
    }
}
