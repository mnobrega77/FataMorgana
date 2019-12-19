<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;
use Gedmo\Sluggable\Util\Urlizer;
use App\Entity\Auteur;
use App\Entity\Editeur;
use App\Entity\Livre;
use App\Entity\Fournisseur;
use App\Entity\Categorie;
use App\Entity\SousCategorie;
use App\Repository\CategorieRepository;
use App\Repository\SousCategorieRepository;
use App\Repository\LivreRepository;
use Doctrine\ORM\EntityRepository;
use App\Form\LivreType;
use App\Form\SousCategorieType;
use App\Form\FournisseurType;




class MainController extends AbstractController
{
    
    /**
     * @Route("/", name="home")
     */
    public function home(CategorieRepository $repo)
    {
        //$repo = $this->getDoctrine()->getRepository(Categorie::class);
        $categories = $repo->findAll();
        return $this->render('main/home.html.twig', [
            'categories' =>$categories
        ]);

    }

    //Page Catégorie

    /**
     * @Route("/categorie/{id}", name="categorie")
     */
    public function showcat(SousCategorieRepository $repo, LivreRepository $repo1, Categorie $categorie)
    {
        $souscategorie = $repo->findByCategorie($categorie->getId());
        //$souscategorie = $categorie->getSousCategories();
        $livres = $repo1->findBooksByCategorie($categorie->getId());

        return $this->render('main/categorie.html.twig', [
            'categorie' =>$categorie,
            'souscategorie' =>$souscategorie,
            'livres' =>$livres

        ]
            );
    }

    //Page SousCatégorie /tous les livres

    /**
     * @Route("/souscategorie/{id}", name="souscategorie")
     */

     public function showscat(SousCategorie $souscategorie, LivreRepository $repo1)
     {
        // $repo = $this->getDoctrine()->getRepository(Souscategorie::class);
        // $souscategorie = $repo->findOneById($souscategorie->getId());

        $livres = $repo1->findBySousCategorie($souscategorie->getId());
        return $this->render('main/souscategorie.html.twig', [
            'souscategorie' =>$souscategorie,
            'livres' =>$livres
        ]);

     }

     // Page Produit

   /**
    * @Route("/livre/{id}", name="livre")
    */
   public function showBook(Livre $livre)
   {
       // $repo = $this->getDoctrine()->getRepository(Livre::class);
       // $livre = $repo->findOneById($livre->getId());

       return $this->render('main/produit.html.twig', [
           'livre' =>$livre
       ]);
   }
}