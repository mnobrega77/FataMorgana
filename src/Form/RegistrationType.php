<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Client;
use App\Form\ClientType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, [

                    'label' => "Nom d'utilisateur",
                   
                ]
                )
            ->add('email', EmailType::class, [
                'attr' => [
                    'label' => "Email"
                ]
            ])
            ->add('password', PasswordType::class, [
                'attr' => [
                    'label' => "Mot de passe"
                ]
            ])
            ->add('confirmPassword', PasswordType::class, [
                
                    'label' => "Confirmation du mot de passe"
                ]
            )
            
            ->add('client', ClientType::class);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
