<?php

namespace App\Form;

use App\Entity\Comment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class CommentFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('author', TextType::class, [
            'attr'=>array(
                'placeholder'=>'Enter the Author!'
            ),
            'constraints' => [
                new NotBlank([
                    'message' => 'author cannot be empty!'
                ]),
            ],
            'required' => false,
            'label' => false
        ])     
        ->add('content', TextType::class, [
            'attr'=>array(
                'placeholder'=>'Enter the Content!'
            ),
            'constraints' => [
                new NotBlank([
                    'message' => 'author cannot be empty!'
                ]),
            ],
            'required' => false,
            'label' => false
        ]);    
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }
}
