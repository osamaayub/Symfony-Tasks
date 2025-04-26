<?php

namespace App\Controller;

use App\Form\ContactFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class ContactController extends AbstractController
{
    #[Route('/contact', name: 'contact_form')]
    public function index(Request $request): Response
    {
        $form = $this->createForm(ContactFormType::class, null);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
           
        }

            return $this->render('contact/index.html.twig', [
                'contactForm' => $form->createView(),
            ]);
    }
    #[Route('/contact/confirm',name:'confirmation')]
    public function confirmationMessage(Request $request):Response{
        $name=$request->query->get('name');
        $email=$request->query->get('email');
        $message=$request->query->get('message');

        return $this->render('confirmationMessage/confirm.html.twig',[
            'name'=>$name,
            'email'=>$email,
            'message'=>$message
            
        ]);
      
    }


}
