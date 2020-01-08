<?php

namespace App\Form;

use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TelType;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                
                    'label' => 'Nom',
                    'attr' => [
                        'placeholder' => "Votre nom"
                    ]    
            ])
            ->add('prenom')
            ->add('adresse')
            ->add('cp', TextType::class, [
                
                    'label' => 'Code Postal'
            ])
            ->add('ville')
            ->add('tel')
            
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Client::class            
        ]);
    }
}
