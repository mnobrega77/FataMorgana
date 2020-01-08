<?php

namespace App\Form;

use App\Entity\Commande;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class CommandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // ->add('date')
            ->add('adFacture', TextType::class, [
                
                'label' => "Adresse de facturation"
            ])
            ->add('cpFacture', TextType::class, [
                
                'label' => "Code Postal"
            ])
            ->add('villeFacture', TextType::class, [
                
                'label' => "Ville"
            ])
            ->add('adLivr', TextType::class, [
                
                'label' => "Adresse de livraison"
            ])
            ->add('cpLivr', TextType::class, [
                
                'label' => "Code Postal"
            ])
            ->add('villeLivr', TextType::class, [
                
                'label' => "Ville"
            ])
            
            //->add('cliId')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Commande::class
            
        ]);
    }
}
