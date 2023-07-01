<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\HomeSliderRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ProductRepository $repoProduct,HomeSliderRepository $repoHomeSlider): Response
    {
        $products = $repoProduct->findAll();
        $homeSlider = $repoHomeSlider->findby(['isDiplayed'=>true]);
        $productBestSeller = $repoProduct->findByisbestseller(1);
        $productSpecialOffer =$repoProduct->findByisspecialoffer(1);
        $productNewArrival = $repoProduct->findByisnewarrival(1);
        $productFeatured = $repoProduct->findByisfeatured(1);
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'product'=>$products,
            'productBestSeller'=>$productBestSeller,
            'productSpecialOffer'=>$productSpecialOffer,
            'productNewArrival'=>$productNewArrival,
            'productFeatured'=>$productFeatured,
            'homeSlider'=>$homeSlider
        ]);
    }

    #[Route('/product/{slug}', name: 'product_details')]
    public function show(?Product $product):Response
    {
        if(!$product){
            return $this->redirectToRoute('app_home');
        }
        return $this->render("home/single_product.html.twig",[
            'product'=>$product
        ]);
    }
}
