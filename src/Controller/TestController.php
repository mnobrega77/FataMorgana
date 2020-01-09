<?php
namespace App\Controller;
 
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
 
use App\Entity\Categorie;
use App\Entity\SousCategorie;
use App\Entity\Livre;
use App\Entity\Fournisseur;
use App\Entity\Editeur;
use App\Entity\Auteur;
use App\Repository\LivreRepository;
use App\Repository\SousCategorieRepository;

 
class TestController extends AbstractController
{
    /**
     * @Route("/test", name="test")
     */
    public function index(SousCategorieRepository $repo)
    {   
        
        //$livre = $repo->findAll();


        // $repo = $this->getDoctrine()->getRepository(Livre::class);
        // $liste = $repo->findAll();

       $souscategorie = $repo->findByCategorie('LTTFRA');
 
        return $this->render('test/index.html.twig', [
            // 'livre' => $livre
            'souscategorie' =>$souscategorie
                    ]);
    }

    /**
     * @Route("/test/showtest", name="showtest")
     */
   public function showBook(LivreRepository $repo)
   {
      $livre = $repo->findOneByTitle('Judas');
       return $this->render('test/showtest.html.twig', [
           'livre' =>$livre
       ]);
   }
    

}
