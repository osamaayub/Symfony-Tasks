<?php

namespace App\Controller;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\User1Type;
use App\Entity\User;
use App\Entity\Profile;
use App\Entity\UserDetails;
use App\Form\User2FormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;


class RegistrationController extends AbstractController{
    private $em;

    public function __construct(EntityManagerInterface $em){
        $this->em=$em;
    }
    //register user using username,email & password
    #[Route('/register/step1',name:'registration_step1')]
    public function registerStep1(Request $request,UserPasswordHasherInterface $passwordhasher):Response{
        $user=new User();
        $form=$this->createForm(User1Type::class,$user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            //set hashed password
            $session=$request->getSession();
           $hashpassword=$passwordhasher->hashPassword($user,$user->getPassword());
           $user->setPassword($hashpassword);
            $session->set('step1',$user);
            return $this->redirectToRoute('registration_step2');
        }
        return $this->render('multiform/step1.html.twig',[
            'form'=>$form->createView()
        ]);
        

    }
    //step 2 for adding address and  phone Number
    #[Route('/register/step2',name:'registration_step2')]
    public function register2(Request $request):Response{

        $session=$request->getSession();
        //if it includes the first step
        if(!$session->has('step1')){
            return $this->redirectToRoute('registration_step1');
        }
         $userDetails=new UserDetails();
        $form=$this->createForm(User2FormType::class,$userDetails);
        $form->handleRequest($request);
        //check if the form is submitted or not
        if($form->isSubmitted() && $form->isValid()){
            $session=$request->getSession();
            //and update the values in the session
            $session->set('step2',$userDetails);
                        return $this->redirectToRoute('registration_review');
        }
     return $this->render('multiform/step2.html.twig',[
        'form'=>$form->createView()
     ]);
    }
    //review the data and save it the entity userDetails
    #[Route('/register/review', name: 'registration_review')]
    public function registerReview(Request $request): Response
    {
        $session = $request->getSession();
    
        if (!$session->has('step1') || !$session->has('step2')) {
            return $this->redirectToRoute('registration_step1');
        }
    
        $step1 = $session->get('step1');
        $step2 = $session->get('step2');
    
        // Create User entity from session data
        $user = new User();
        $user->setUsername($step1->getUserName());
        $user->setEmail($step1->getEmail());
        $user->setPassword($step1->getPassword());
    
        // Create Profile and set the User
        $profile = new Profile();
        $profile->setFirstname('jamal');
        $profile->setLastname('pervaiz');
        // $profile->setFirstname($step2['firstname']);
        // $profile->setLastname($step2['lastname']);
    
        // Set Profile to User
        $user->setProfile($profile); // Link Profile to User
    
        // Create UserDetails
        $userDetails = new UserDetails();
        $userDetails->setAddress($step2->getAddress());
        $userDetails->setPhoneNumber($step2->getPhoneNumber());
        $userDetails->setUsername($step1->getUsername());
        $userDetails->setEmail($step1->getEmail());       
        $userDetails->setPassword($user->getPassword());
        $userDetails->setUser($user); // Link UserDetails to User
        $user->setUserDetails($userDetails);
    
        // Persist all entities
        $this->em->persist($profile);       // Profile must be persisted separately
        $this->em->persist($user);          // Persist User (which also persists Profile)
        $this->em->persist($userDetails);   // Persist UserDetails
        $this->em->flush();
    
        return $this->render('show/index.html.twig', [
            'user' => $user,  // Show User data
            'userdetails'=>$userDetails //show userDetails data
        ]);
    }
    
    
    
}



?>