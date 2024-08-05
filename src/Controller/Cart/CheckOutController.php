<?php

namespace App\Controller\Cart;

use App\Form\CheckoutType;
use App\Services\CartServices;
use App\Services\OrderServices;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CheckOutController extends AbstractController
{
    private $cartServices;
    private $session;
    public function __construct(
        CartServices $cartServices,
        RequestStack $requestStack
    ) {
        $this->cartServices = $cartServices;
        $this->session = $requestStack->getSession();
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
        if($this->session->get('checkout_data')){
            return $this->redirectToRoute('checkout_confirm');
        }

        $form = $this->createForm(CheckoutType::class, null, ['user' => $user]);

        return $this->render('check_out/index.html.twig', [
            'cart' => $cart,
            'checkout' => $form->createView(),
        ]);
    }

    #[Route('/checkout/confirm', name: 'checkout_confirm')]
    public function confirm(Request $request, OrderServices $orderServices): Response
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
        if (
            ($form->isSubmitted() && $form->isValid()) ||
            $this->session->get('checkout_data')
        ) {
            if ($this->session->get('checkout_data')) {
                $data = $this->session->get('checkout_data');
            } else {
                $data = $form->getData();
                $this->session->set('checkout_data', $data);
            }

            $address = $data['address'];
            $carrier = $data['carrier'];
            $informations = $data['informations'];
            $cart['checkout'] = $data;
            $reference = $orderServices->saveCart($cart,$user);

            return $this->render('check_out/confirm.html.twig', [
                'address' => $address,
                'carrier' => $carrier,
                'informations' => $informations,
                'cart' => $cart,
                'reference' => $reference,
                'checkout' => $form->createView(),
            ]);
        }
        return $this->redirectToRoute('app_check_out');
    }

    #[Route('/checkout/edit', name: 'checkout_edit')]
    public function checkoutEdit():Response{
        $this->session->set('checkout_data',[]);
        return $this->redirectToRoute('app_check_out');
    }
}
