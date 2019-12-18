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

     //CRUD 

     /**
     * @Route("/liste", name="liste")
     */

     public function showAll(LivreRepository $repo)
     {
        $livres = $repo->findAll();
        return $this->render('main/liste.html.twig', [
            'livres' =>$livres
        ]);
     }

     /**
      * @Route("/liste/new", name="ajouter_livre")
      */

      public function create(Request $request, EntityManagerInterface $em)
      {
          
          $livre = new Livre();
          $form = $this->createForm(LivreType::class, $livre);
          $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            /** @var UploadedFile $uploadedFile */
            $uploadedFile = ($form['imageFile']->getData());

            if ($uploadedFile){
                $destination = $this->getParameter('kernel.project_dir').'/public/build/images';
                  
                $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = Urlizer::urlize($originalFilename).'_' .uniqid(). '.' .$uploadedFile->guessExtension(); 

                $uploadedFile->move(
                $destination,
                $newFilename
                );


                $livre->setImage($newFilename);  
            }         
            // Insérer un nouvel auteur

                if ($request->request->get("autre_auteur", null)) {
                    $aut = new Auteur();
                    $aut->setNom($request->request->get("autre_auteur"));
                    
                    $livre->setAuteur($aut);
                    $em->persist($aut);
                }

            // Insérer un nouvel éditeur 
                if ($request->request->get("autre_editeur", null)) {
                    $edit = new Editeur();
                    $edit->setNom($request->request->get("autre_editeur"));
                    
                    $livre->setEditeur($edit);
                    $em->persist($edit);
                }
                // dump($request);
                // dump($livre);
                $em->persist($livre);
                $em->flush();
                $this->addFlash('success', 'Livre ajouté avec succès!');

            //return $this->redirectToRoute('liste');

        }
        return $this->render('main/create.html.twig', [
            'livre' => $livre,
            'form' => $form->createView(),
            
         ]);

      }
    

    
    /**
     * @Route("/liste/{id}", name="editer_livre", methods="GET|POST")
     */
     public function edit(Livre $livre, Request $request, EntityManagerInterface $em){
                 

        $form = $this->createForm(LivreType::class, $livre);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            /** @var UploadedFile $uploadedFile */
            $uploadedFile = ($form['imageFile']->getData());

            if ($uploadedFile){
                $destination = $this->getParameter('kernel.project_dir').'/public/build/images';
                  
                $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = Urlizer::urlize($originalFilename).'_' .uniqid(). '.' .$uploadedFile->guessExtension(); 

                $uploadedFile->move(
                $destination,
                $newFilename
                );


                $livre->setImage($newFilename);
        }
         // Insérer un nouvel auteur

         if ($request->request->get("autre_auteur", null)) {
            $aut = new Auteur();
            $aut->setNom($request->request->get("autre_auteur"));
            
            $livre->setAuteur($aut);
            $em->persist($aut);
        }

    // Insérer un nouvel éditeur 
        if ($request->request->get("autre_editeur", null)) {
            $edit = new Editeur();
            $edit->setNom($request->request->get("autre_editeur"));
            
            $livre->setEditeur($edit);
            $em->persist($edit);
        }

            $em->persist($livre);
            $em->flush();

            $this->addFlash('success', 'Livre modifié avec succès!');
            return $this->redirectToRoute('liste');

        }

         return $this->render('main/edit.html.twig', [
            'livre' => $livre,
            'form' => $form->createView(),
            
         ]);
         }

    /**
     * @Route("/liste/{id}", name="supprimer_livre", methods="DELETE")
     */
    public function delete(Livre $livre, Request $request, EntityManagerInterface $em)
    {   
        //if token is valid
        if($this->isCsrfTokenValid('delete' . $livre->getId(), $request->get('_token'))){

            $em->remove($livre);
            $em->flush();
        // return new Response('Suppression');
        $this->addFlash('success', 'Livre supprimé avec succès!');
        }
        
        return $this->redirectToRoute('liste');
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

    // 
    // public function temporaryUploadAction(Request $request)
    // {
    //     // dd($request->files->get('imagename'));

    //     /** @var UploadedFile $uploadedFile */
    //     $uploadedFile = $request->files->get('imagename');
        
    // }

      // Créer un nouveau fournisseur

    /**
      * @Route("/main/ajoutfournisseur", name="creer_fournisseur")
      */

      public function newFour(Request $request, EntityManagerInterface $em)
      {
          // test
          $four = new Fournisseur();
          $formFour = $this->createForm(FournisseurType::class, $four);
          $formFour->handleRequest($request);

        if($formFour->isSubmitted() && $formFour->isValid()) {

                 // dump($request);
                // dump($livre);
                $em->persist($four);
                $em->flush();
                $this->addFlash('success', 'Fournisseur créé avec succès!');
                return $this->redirectToRoute('ajouter_liste');

        }
            return $this->render('main/nfournisseur.html.twig', [
                'four' => $four,
                'formFour' => $formFour->createView(),
            ]);
    }

}