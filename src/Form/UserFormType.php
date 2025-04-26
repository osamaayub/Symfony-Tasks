<?php

// src/Form/UserFormType.php
namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use App\Form\User2FormType;
use Symfony\Component\Form\Extension\Core\Type\{
    TextType,
    EmailType,
    PasswordType
};
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, [
                'label' => false,
                'attr' => array(
                    'placeholder' => 'Enter the username'
                ),
                'required' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'username cant be empty!'
                    ])
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => false,
                'attr' => array(
                    'placeholder' => 'Enter the email'
                ),
                'required' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'email cannot be empty'
                    ])
                ]
            ])
            ->add('password', PasswordType::class, [
                'required' => false,
                'attr' => array(
                    'placeholder' => 'Enter the password!'
                ),
                'constraints' => [
                    new NotBlank([
                        'message' => 'password cant be empty!'
                    ]),
                    new Length([
                        'min' => 3,
                        'max' => 8,
                        'minMessage' => 'password cannot be less than 3 characters',
                        'maxMessage' => 'password cannot be more than 8 characters'
                    ])
                ]

            ]);
           $builder->add('profile',ProfileFormType::class,[
            'label'=>false
           ]);
           $builder->add('userdetails',User2FormType::class,[ 
                    'label'=>false
           ]);



        
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
?>
