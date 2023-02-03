<?php

namespace App\Services;

use App\Entity\Cart;
use App\Entity\Order;
use App\Entity\Carrier;
use App\Entity\CartDetails;
use App\Entity\OrderDetails;
use Doctrine\ORM\EntityManagerInterface;

class OrderServices
{
    private $manager;
    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;

    }

    public function createOrder($cart)
    {
        
        $order = new Order();
        $order
        ->setReference($cart->getReference())
        ->setCarriername($cart->getCarriername())
        ->setCarrierprice($cart->getCarrierprice())
        ->setFullname($cart->getFullname())
        ->setDeleveryaddress($cart->getDeleveryaddress())
        ->setMoreinformations($cart->getMoreinformations())
        ->setQuantity($cart->getQuantity())
        ->setSubTotalHt($cart->getSubTotalHt())
        ->setTaxe($cart->getTaxe())
        ->setSubTotalTTC($cart->getSubTotalTTC())
        ->setUserOrder($cart->getUserCart())
        ->setCreatedAt($cart->getCreatedAt());
        $this->manager->persist($order);

        $products = $cart->getCaartDetails()->getVlaues();
        foreach ($products as $cart_products) {
            
           $orderDetails = new OrderDetails();
           $orderDetails->setOrders($order)
                        ->setProductname($cart_products->getProductName())
                        ->setProducprice($cart_products->getProductprice())
                        ->setQuantity($cart_products->getQuantity())
                        ->setSubTotalHT($cart_products->getSubTotalHT())
                        ->setSubTotalTTC($cart_products->getSubTotalTTC())
                        ->setTaxe($cart_products->getTaxe());
            $this->manager->persist($orderDetails);            
        }
        $this->manager->flush();
        return $order;
    }

    public function saveCart($data, $user)
    {
        $cart = new Cart();
        $reference = $this->generateUuid();
        $address = $data['checkout']['address'];
        $carrier = $data['checkout']['carrier'];
        $informations = $data['checkout']['informations'];

        $cart
            ->setReference($reference)
            ->setCarriername($carrier->getName())
            ->setCarrierprice($carrier->getPrice()/100)
            ->setFullname($address->getFullname())
            ->setDeleveryaddress($address)
            ->setMoreinformations($informations)
            ->setQuantity($data['data']['quantity_cart'])
            ->setSubTotalHt($data['data']['subTotalHT'])
            ->setTaxe($data['data']['Taxe'])
            ->setSubTotalHt(
                $data['data']['subTotalTTC'] + $carrier->getPrice() / 100,
                2
            )
            ->setUserCart($user)
            ->setCreatedAt(new \DateTime());
        $this->manager->persist($cart);

        $cart_details_array = [];

        foreach ($data['products'] as $products) {
            $cartDetails = new CartDetails();
            $subTotal =
                ($products['quantity'] * $products['product']->getPrice()) /
                100;

            $cartDetails
                ->setCarts($cart)
                ->setProductname($products['product']->getName())
                ->setProducprice($products['product']->getPrice())
                ->setQuantity($products['quantity'])
                ->setSubTotalHT($subTotal)
                ->setSubTotalTTC($subTotal * 1.2)
                ->setTaxe($subTotal * 0.2);
            $this->manager->persist($cartDetails);
            $cart_details_array[] = $cartDetails;
        }
        $this->manager->flush();
        return $reference;
    }

    public function generateUuid()
    {
        mt_srand((float) microtime() * 100000);
        $charid = strtoupper(md5(uniqid(rand(), true)));
        $hyphen = chr(45);
        $uuid =
            '' .
            substr($charid, 0, 8) .
            $hyphen .
            substr($charid, 8, 4) .
            $hyphen .
            substr($charid, 12, 4) .
            $hyphen .
            substr($charid, 16, 4) .
            $hyphen .
            substr($charid, 20, 12);
        return $uuid;
    }
}
