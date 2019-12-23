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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @IsGranted("ROLE_ADMIN")
 */

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="liste")
     */
    

    public function showAll(LivreRepository $repo)
    {
        // $this->denyAccessUnlessGranted('ROLE_ADMIN');
       
       $livres = $repo->findAll();
       return $this->render('/admin/liste.html.twig', [
           'livres' =>$livres
       ]);
       
    }

    /**
     * @Route("/admin/liste/new", name="ajouter_livre")
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
       return $this->render('admin/create.html.twig', [
           'livre' => $livre,
           'form' => $form->createView(),
           
        ]);

     }
   

   
   /**
    * @Route("/admin/liste/{id}", name="editer_livre", methods="GET|POST")
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

        return $this->render('admin/edit.html.twig', [
           'livre' => $livre,
           'form' => $form->createView(),
           
        ]);
        }

   /**
    * @Route("/admin/liste/{id}", name="supprimer_livre", methods="DELETE")
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

   

   // 
   // public function temporaryUploadAction(Request $request)
   // {
   //     // dd($request->files->get('imagename'));

   //     /** @var UploadedFile $uploadedFile */
   //     $uploadedFile = $request->files->get('imagename');
       
   // }

     // Créer un nouveau fournisseur

   /**
     * @Route("/admin/ajoutfournisseur", name="creer_fournisseur")
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
           return $this->render('admin/nfournisseur.html.twig', [
               'four' => $four,
               'formFour' => $formFour->createView(),
           ]);
   }

}
