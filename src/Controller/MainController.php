<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;
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
    private $livreRepo;
    private $catRepo;
    private $scatRepo;
    public function __construct(LivreRepository $livreRepo, CategorieRepository $catRepo, SousCategorieRepository $scatRepo){
        $this->livreRepo=$livreRepo;
        $this->catRepo = $catRepo;
        $this->scatRepo= $scatRepo;
    }


    #[Route("/", name:"home")]

    public function home(CategorieRepository $repo)
    {
        //$repo = $this->getDoctrine()->getRepository(Categorie::class);
        $categories = $this->catRepo->findAll();
        return $this->render('main/home.html.twig', [
            'categories' =>$categories
        ]);

    }

    //Page Catégorie

    #[Route('/categorie/{id}', name: 'categorie')]
    public function showcat(Categorie $categorie)
    {
        $souscategorie = $this->scatRepo->findByCategorie($categorie->getId());
        //$souscategorie = $categorie->getSousCategories();
        $livres = $this->livreRepo->findBooksByCategorie($categorie->getId());

        return $this->render('main/categorie.html.twig', [
            'categorie' =>$categorie,
            'souscategorie' =>$souscategorie,
            'livres' =>$livres

        ]
            );
    }

    //Page SousCatégorie /tous les livres

    #[Route("/souscategorie/{id}", name:"souscategorie")]

     public function showscat(SousCategorie $souscategorie)
     {
        $livres = $this->livreRepo->findBySousCategorie($souscategorie->getId());
        return $this->render('main/souscategorie.html.twig', [
            'souscategorie' =>$souscategorie,
            'livres' =>$livres
        ]);

     }

     // Page Produit


    #[Route("/livre/{id}", name:"livre")]
   public function showBook(Livre $livre = null)
   {
       // $repo = $this->getDoctrine()->getRepository(Livre::class);
       // $livre = $repo->findOneById($livre->getId());

       if(null === $livre) return $this->json(["message"=>"aucune livre"]);
       return $this->render('main/produit.html.twig', [
           'livre' =>$livre
       ]);
   }
    #[Route("/recherche", name:"recherche")]

    public function recherche(Request $request)
    {
        $critere = $request->request->get("recherche");

        $resultats = $this->livreRepo->findBooksByData($critere);
        // dump($resultats);


        return $this->render('main/recherche.html.twig', [
            'resultats' => $resultats
        ]);

    }
}