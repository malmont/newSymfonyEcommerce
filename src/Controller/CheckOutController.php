<?php

namespace App\Controller;

use App\Form\CheckoutType;
use App\Services\CartServices;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CheckOutController extends AbstractController
{
    private $cartServices;

    public function __construct(CartServices $cartServices)
    {
        $this->cartServices = $cartServices;
    }
    #[Route('/checkout', name: 'app_check_out')]
    public function index(Request $request): Response
    {
        /**
         * @var User
         */
        $user = $this->getUser();

        $cart = $this->cartServices->getFullCart();
        if (!isset($cart['products'])) {
            return $this->redirectToRoute('app_home');
        }

        if (!$user->getAdresses()->getValues()) {
            $this->addFlash(
                'check_out_message',
                'please add an address to your account without continuing!'
            );
            return $this->redirectToRoute('app_adress_new');
        }

        $form = $this->createForm(CheckoutType::class, null, ['user' => $user]);

        return $this->render('check_out/index.html.twig', [
            'cart' => $cart,
            'checkout' => $form->createView(),
        ]);
    }
    #[Route('/checkout/confirm', name: 'checkout_confirm')]
    public function confirm(Request $request): Response
    {
        /**
         * @var User
         */
        $user = $this->getUser();

        $cart = $this->cartServices->getFullCart();

        if (!isset($cart['products'])) {
            return $this->redirectToRoute('app_home');
        }

        if (!$user->getAdresses()->getValues()) {
            $this->addFlash(
                'check_out_message',
                'please add an address to your account without continuing!'
            );
            return $this->redirectToRoute('app_adress_new');
        }
        $form = $this->createForm(CheckoutType::class, null, ['user' => $user]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $address = $data['address'];
            $carrier = $data['carrier'];
            $informations = $data['informations'];
            return $this->render('check_out/confirm.html.twig', [
                'address' => $address,
                'carrier' => $carrier,
                'informations' => $informations,
                'cart' => $cart,
                'checkout' => $form->createView(),
            ]);
        }
        return $this->redirectToRoute('app_check_out');
    }
}
