<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
class HomeController extends AbstractController
{
      #[Route("/home" ,name:'home_page')]
    public function index(): Response
    {
     return new Response('Its a symfony application and this is a basic home route');  
    }
}





?>