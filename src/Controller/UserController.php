<?php


namespace App\Controller;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Entity\Profile;
use App\Form\UserFormType;
use App\Form\ProfileFormType;


class UserController extends AbstractController
{
    private $em;
    private $userRepository;
    public function __construct(EntityManagerInterface $em, UserRepository $user)
    {
        $this->em = $em;
        $this->userRepository = $user;
    }
    #[Route('/register', name: 'user_registration')]
    public function register(Request $request, UserPasswordHasherInterface $passwordHash): Response
    {
        $user = new User();
        $form = $this->createForm(UserFormType::class, $user);
        //set the user profile
        $user->setProfile(new Profile());
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $password = $form->get('password')->getData();
            //take the plain password and hash password
            $hashpassword = $passwordHash->hashPassword($user, $password);
            $user->setPassword($hashpassword);

            $this->em->persist($user);
            $this->em->flush();
            //redirect to the user profile creation route
            return $this->redirectToRoute('user_profile_creation', [
                'id' => $user->getId()
            ]);
        }
        return $this->render('profile/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    //profile creation route for user
    #[Route('user/profile/create', name: 'user_profile_creation')]
    public function createProfile(Request $request): Response
    {
        $profile = new Profile();
        $form = $this->createForm(ProfileFormType::class, $profile);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //get the firstname for the user to
            $firstname = $form->get('firstname')->getData();
            //set the firstname
            $profile->setFirstname($firstname);
            //get the lastname for the user
            $lastname = $form->get('lastname')->getData();
            //set the last name
            $profile->setLastname($lastname);
            $this->em->persist($profile);
            $this->em->flush();
            //redirect to the show profile page
            return $this->redirectToRoute('user_profile');
            
        }

        return $this->render('profile.html.twig', [
            'form' => $form->createView()
        ]);
    }
    //route to show user & profile data
    #[Route('/profile',name:'user_profile')]
    public function showProfile():Response{
        //get the user data from the database
       $user=$this->userRepository->createQueryBuilder('u')
       ->join('u.profile','p')
       ->addSelect('p')
       ->getQuery()
       ->getResult();

      return $this->render('user-profile/profile.html.twig',[
        'users'=>$user
      ]);
    }
}





?>

