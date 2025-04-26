<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProductController extends AbstractController
{
    #[Route('/products', name: 'products_list')]
    public function index(): Response
    {
        $products = array(
            ['name' => 'phone', 'Type' => 'Samsung', 'price' => '50000'],
            [
                'name' => 'charger',
                'Type' => 'HP',
                'price' => '450'
            ]
        );
        return $this->render('product/index.html.twig', [
            'products' => $products,
        ]);
    }
}
