<?php

namespace App\Controller;

use App\Form\CommentFormType;
use App\Entity\Comment;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;

class BlogController extends AbstractController
{
    private $em;
    private $postRepository;
    public function __construct(EntityManagerInterface $em,PostRepository $post){
        $this->em=$em;
        $this->postRepository=$post;
    }
    // Route for showing all the posts
    #[Route('/blog', name: 'blog_lists')]
    public function index(): Response
    {
        //get all the posts
        $posts=$this->postRepository->createQueryBuilder('p')
        ->leftJoin('p.comments','c')
        ->addSelect('count(c.id) AS Hidden commentCount')
        ->groupBy('p.id')
        ->orderBy('commentCount','DESC')
        ->getQuery()
        ->getResult();
        return $this->render('blog/index.html.twig', [
            'posts'=>$posts
        ]);
    }
    // get Single Post with comments as well
    #[Route('blog/{id}',name:'blog_post')]
    public function singlePost(int $id,Request $request):Response{
    
         $post=$this->postRepository->createQueryBuilder('p')
         ->leftJoin('p.comments','c')
         ->addSelect('c')
         ->where('p.id=:id')
         ->setParameter('id',$id)
         ->getQuery()
         ->getOneOrNullResult();
           //if the  product is not found
         if(!$post){
          throw new NotFoundHttpException('Post not found!');
         }
         $comment=new Comment();
         $form = $this->createForm(CommentFormType::class,$comment);
         $form->handleRequest($request);
         //check if the form is submitted and the data is valid
         if($form->isSubmitted() && $form->isValid()){
          //before creating new comment we need to set it with the post due
         //comment has many to one relationship
          $comment->setPost($post);
           $this->em->persist($comment);
           $this->em->flush();
           return $this->redirectToRoute('blog_post',['id'=>$id]);
         }
        return $this->render('show.html.twig',[
           'post'=>$post,
           'form'=>$form->createView()
        ]);
    }
}
