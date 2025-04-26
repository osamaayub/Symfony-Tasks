<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
class ContactFormType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options): void
  {
    $builder
      ->add('name', TextType::class, [
        'required' => false,
        'constraints' => [
          new NotBlank([
            'message' => 'name cannot be empty!'
          ])
        ],
        'attr' => array(
          'placeholder' => 'Enter the Name'
        )
      ])
      ->add('email', EmailType::class, [
        'required' => false,
        'constraints' => [
          new Email([
            'message' => 'Enter the Correct Email with @ format'
          ]),
          new NotBlank()
        ],
        'attr' => array(
          'placeholder' => 'Enter the Email'
        )
      ])
      ->add('message', TextType::class, [
        'required' => false,
        'constraints' => [
          new NotBlank([
            'message' => 'message cannot be empty!'
          ]),
        ],
        'attr' => array(
          'placeholder' => 'Enter the Message'
        )
      ])
    ;
  }

  public function configureOptions(OptionsResolver $resolver): void
  {
    $resolver->setDefaults([
      // Configure your form options here
    ]);
  }
}
