<?php

namespace App\Form;

use App\Entity\Profile;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class ProfileFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname',TextType::class,[
                'label'=>false,
                'required'=>false,
                'attr'=>array(
                 'placeholder'=>'Enter the firstName'
                ),
                'constraints'=>[
                    new NotBlank([
                        'message'=>'firstName cannot be empty!'
                    ])
                ]
            ])
            ->add('lastname',TextType::class,[
                'label'=>false,
                'required'=>false,
                'attr'=>array(
                    'placeholder'=>'Enter the lastname!'
                ),
               'constraints'=>[
                new NotBlank([
                    'message'=>'lastname not empty'
                ])
               ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Profile::class,
        ]);
    }
}
