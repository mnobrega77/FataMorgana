<?php

namespace App\Form;

use App\Entity\Livre;
use App\Repository\LivreRepository;
use App\Entity\SousCategorie;
use App\Form\SousCategorieType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\FormView; 
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\ChoiceList\View\ChoiceView;

class LivreType extends AbstractType
{
    private $repo;
    
    public function __construct(LivreRepository $repo)
    {
        $this->repo = $repo;
    }
   

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', TextType::class, [
                'attr' => [
                    'placeholder' => 'Identifiant du livre'
                ]
            ])
            ->add('ref', TextType::class, [
                'attr' => [
                    'placeholder' => 'Référence du livre'
                ],
                'label' =>'Référence'
            ])
            ->add('titre', TextType::class, [
                'attr' => [
                    'placeholder' => "Titre du livre"
                ]     
            ])
            ->add('auteur')
            

            ->add('detail', TextareaType::class, [
                'label' => 'Détail'
            ])
            
            ->add('resume', TextareaType::class, [
                'label' => 'Résumé'
            ])
            ->add('prachat', NumberType::class, [
                'label' => 'Prix',
                'scale' => 2
                ])
           
            ->add('imageFile', FileType::class, [
                'required' => false,
                'mapped' => false,
                'label' => 'Nouvelle image',
                'constraints' => [
                    new File([
                        'maxSize' => '5M',
                        'mimeTypes' => [
                            'image/jpg',
                            'image/jpeg',
                            'image/png'
                        ],
                        'mimeTypesMessage' => "L'image ne respecte pas le format attendu!"
                    ])
                ]
            ])
            

            ->add('stock')
            ->add('dateEdition', DateType::class, [
                'widget' => 'single_text'
            ])
            ->add('souscategorie')
            
            ->add('editeur')

            ->add('fournisseur')

            ->add('save', SubmitType::class, array('label' => 'Valider'))
        ;
    }

    // public function finishView(FormView $view, FormInterface $form, array $options)
    // {
    //     $newChoice = new ChoiceView(array(), 'add', 'Autre'); // <- new option
    //     $view->children['auteur']->vars['choices'][] = $newChoice; //<- adding the new option 
    // }



    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Livre::class,
            'choice_label' => "nom",
            'translation_domain' => 'forms'
        ]);
    }
}
