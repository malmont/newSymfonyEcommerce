<?php

namespace App\Services;

use App\Entity\Carrier;
use App\Entity\Cart;
use App\Entity\CartDetails;
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
            ->setCarrierprice($carrier->getPrice())
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
