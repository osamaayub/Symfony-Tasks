<?php

namespace App\Form;

use App\Entity\UserDetails;
use Symfony\Component\Form\AbstractType;
use App\Entity\User;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class User2FormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('address',TextType::class,[
                'required'=>false,
                'attr'=>array(
                    'placeholder'=>'Enter the address'
                ),
                'constraints'=>[
                    new NotBlank([
                        'message'=>'address cannot be empty!'
                    ])
                ]

            ])
            ->add('phone_number',TelType::class,[
                'required'=>false,
                'attr'=>array(
                    'placeholder'=>'Enter The phoneNumber'
                ),
                'constraints'=>[
                    new NotBlank([
                        'message'=>'phoneNumber cannot be empty!'
                    ]),
                ]
            ]) ;
    }
    public function configureOptions(OptionsResolver $resolver): void{
        $resolver->setDefaults([
            'data_class' => UserDetails::class
        ]);
    }
}
