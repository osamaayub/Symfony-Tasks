<?php

namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

use App\Entity\User;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;


class User1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username',TextType::class,[
                'required'=>false,
                'attr'=>array(
                    'placeholder'=>'Enter the username'
                ),
                'constraints'=>[
                    new NotBlank([
                        'message'=>'username cannot be empty!'
                    ])
                ]
            ])
            ->add('email',EmailType::class,[
                'attr'=>array(
                    'placeholder'=>'Enter the email'
                ),
                'required'=>false,
                'constraints'=>[
                    new Email([
                        'message'=>'email must be of valid format missing @'
                    ]),
                    new NotBlank()
                ]
            ])
            ->add('password',PasswordType::class,[
                'attr'=>array(
                    'placeholder'=>'Enter the Password'
                ),
                'required'=>false,
                'constraints'=>[
                    new NotBlank(),
                    new Length([
                        'min'=>3,
                        'max'=>8,
                        'minMessage'=>'password cannot be more than 3 characters',
                        'maxMessage'=>'password cannot be more than 8 characters'
                    ])
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void{
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
   
}
