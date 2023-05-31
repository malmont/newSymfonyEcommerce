<?php

namespace App\Services;

use App\Entity\Cart;
use App\Entity\Order;
use App\Entity\Carrier;
use App\Entity\CartDetails;
use App\Entity\OrderDetails;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;

class OrderServices
{
    private $manager;
    private $repoProduct;
    public function __construct(EntityManagerInterface $manager,ProductRepository $repoProduct)
    {
        $this->manager = $manager;
        $this->repoProduct = $repoProduct;
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

        $products = $cart->getCartDetails()->getValues();
        foreach ($products as $cart_products) {
            
           $orderDetails = new OrderDetails();
           $orderDetails->setOrders($order)
                        ->setProductname($cart_products->getProductName())
                        ->setProducprice($cart_products->getProducprice())
                        ->setQuantity($cart_products->getQuantity())
                        ->setSubTotalHT($cart_products->getSubTotalHT())
                        ->setSubTotalTTC($cart_products->getSubTotalTTC())
                        ->setTaxe($cart_products->getTaxe());
            $this->manager->persist($orderDetails);            
        }
        $this->manager->flush();
        return $order;
    }

    public function getLineItems($cart){
        $cartDetails = $cart->getCartDetails();
        $line_items = [];
        foreach($cartDetails as $details){
            $product = $this->repoProduct->findOneByName($details->getProductName());
            $line_items[] = [
                'price_data' =>[
                  'currency' =>'usd',
                  'unit_amount'=>$product->getPrice(),
                  'product_data'=>[
                    'name'=>$product->getName(),
                   //  'images'=>[$_ENV['YOUR_DOMAIN'].'/uploads/products/'.$product->getImage()]
                  ],
                ],
                'quantity'=> $details->getQuantity(),
              ];
            }
              //taxe
              $line_items[] = [
                'price_data' =>[
                  'currency' =>'usd',
                  'unit_amount'=>$cart->getTaxe()*100,
                  'product_data'=>[
                    'name'=>"TVA(20%)",
                   //  'images'=>[$_ENV['YOUR_DOMAIN'].'/uploads/products/'.$product->getImage()]
                  ],
                ],
                'quantity'=> 1,
              ];

              //carrier

              $line_items[] = [
                'price_data' =>[
                  'currency' =>'usd',
                  'unit_amount'=>$cart->getCarrierprice()*100,
                  'product_data'=>[
                    'name'=>$cart->getCarriername(),
                   //  'images'=>[$_ENV['YOUR_DOMAIN'].'/uploads/products/'.$product->getImage()]
                  ],
                ],
                'quantity'=> 1,
              ];              
              return $line_items;
       
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
            ->setSubTotalTTC($data['data']['subTotalTTC'] + $carrier->getPrice() / 100,2)
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
