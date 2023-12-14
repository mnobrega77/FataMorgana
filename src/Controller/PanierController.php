<?php

namespace App\Controller;

use App\Entity\Facture;
use App\Entity\Livre;
use App\Entity\Commande;
use App\Entity\Contient;
use App\Form\CommandeType;
use App\Repository\LivreRepository;
use App\Repository\UserRepository;
use App\Service\PanierService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;

class PanierController extends AbstractController
{

    private $ps;
    private $uRepo;
    private $em;
    private $requestStack;
    private $lvRepo;
    public function __construct(PanierService $ps, UserRepository $uRepo, EntityManagerInterface $em, RequestStack $requestStack, LivreRepository $lvRepo){
        $this->ps=$ps;
        $this->uRepo = $uRepo;
        $this->em=$em;
        $this->requestStack = $requestStack;
        $this->lvRepo = $lvRepo;
    }

    #[Route("/panier/", name:"panier_liste")]

    public function liste()
    {

        $session = $this->requestStack->getSession();
        $panier = $session->get("panier", []);

//        dd($panier);

        $livres = $this->lvRepo->findById(array_keys($panier));
        $prixTotal = 0;
        $total = 0;

        foreach($livres as $item) {
            $prix = $item->getPrix();
//            dd($prix);
            $prixTotal = $prix + $prix*$panier[$item->getId()];

            if ($this->getUser()){
                $usermail = $this->getUser()->getUserIdentifier();
                $realUser = $this->uRepo->findOneBy(["email"=>$usermail]);
                if($realUser->getClient()){
//                    dd($realUser->getClient()->getCoeff());
                    $item->prixapayer = ( $prix / 2) *  $realUser->getClient()->getCoeff();
//                    dd($item->prixapayer);
                }
                else{
                    $item->prixapayer = $prix ;
                }
            }
            else {
                $item->prixapayer = $prix ;
                dd($item->prixapayer);
            }
            $total += $item->prixapayer*$panier[$item->getId()];
        }

//         dd($livres);
        // dump($panier);

        return $this->render('panier/index.html.twig', [
            "livres" => $livres,
            "panier" => $panier,
            "total" => $total
        ]);
    }

    #[Route("/panier_add/{id}", name:"panier_add")]

    public function add(Request $request, SessionInterface $session, Livre $item)
    {
        $panier = $session->get("panier", []);

        if ( $item == NULL ||  $item->getStock()==0) {
            
            $session->getFlashBag()->set('error', "Le produit est momentanémant indisponible!");          
            return $this->redirectToRoute('panier_liste');

       }else{

            if (!array_key_exists($item->getId(), $panier))
            {
                $panier[$item->getId()] = 1;
            }
            else 
            {
                $panier[$item->getId()]++;
            }
//            dd($item->getPrix());
       }
       
        $session->set("panier", $panier);
//        dd($session);

        //redirect to last route
        $referer = $request->headers->get('referer'); 
        return new RedirectResponse($referer);
        
    }

     /**
     * @Route("/panier_remove/{id}", name="panier_remove")
     */
    public function remove(SessionInterface $session, $id)
    {
        $panier = $session->get("panier", []);

        unset ($panier[$id]);
        
        $session->set("panier", $panier);

        return $this->redirectToRoute("panier_liste");
    }

    /**
     * @Route("/panier_plus/{id}", name="panier_plus")
     */
    public function plus(SessionInterface $session, Livre $item)
    {
        $panier = $session->get("panier", []);
        
        $qtyAvailable = $item->getStock();

            if($qtyAvailable >= $panier[$item->getId()]){
                $panier[$item->getId()]++;
            }else {
                $session->getFlashBag()->set('error', "La quantité dépasse le stock disponible!");
                return $this->redirectToRoute( 'panier_liste');
            }
        
        $session->set("panier", $panier);

        return $this->redirectToRoute("panier_liste");
    }

    /**
     * @Route("/panier_moins/{id}", name="panier_moins")
     */
    public function moins(SessionInterface $session, $id)
    {
        $panier = $session->get("panier", []);

        $panier[$id]--;
        if ($panier[$id]==0)
            unset ($panier[$id]);
        
        $session->set("panier", $panier);

        return $this->redirectToRoute("panier_liste");
    }

    /**
     * @Route("/panier_valider", name="panier_valider")
     */

    public function commande(Request $request, EntityManagerInterface $em, SessionInterface $session)
    {
        $commande = new Commande();
        $client = $this->getUser()->getClient();
        // dump($client);
        
        $panier = $session->get("panier", []);
        $livres = $this->lvRepo->findById(array_keys($panier));
        $prixTotal = 0;
        $total = 0;

        foreach($livres as $item) {
            $prixTotal = $item->getPrix() + $item->getPrix()*$panier[$item->getId()];
            $item->prixapayer = ( $item->getPrix() / 2) *  $this->getUser()->getClient()->getCoeff();
            $total += $item->prixapayer*$panier[$item->getId()];
            
        }


        $commande->setCliId($client);
        $commande->setDate(new \DateTime());
        $commande->setAdFacture($client->getAdresse());
        $commande->setVilleFacture($client->getVille());
        $commande->setCpFacture($client->getCp());
        $commande->setAdLivr($client->getAdresse());
        $commande->setVilleLivr($client->getVille());
        $commande->setCpLivr($client->getCp());
        $commande->setCpLivr($client->getCp());
        
        $form = $this->createForm(CommandeType::class, $commande);
        $form->handleRequest($request);
        
        dump($panier);

        if($form->isSubmitted() && $form->isValid()) {
            
            $em->persist($commande);
            

            foreach ($panier as $id_livre => $qte_livre) {
                $contient = new Contient();
                $livre = $this->lvRepo->find($id_livre);
                $contient->setCmmdId($commande);
                $contient->setLvrId($livre);
                $contient->setCmmdQte($qte_livre);
                $contient->setLvrPrunitHT($livre->prixapayer);

                $em->persist($contient);
                $em->flush();
            }
            $fc = new Facture();
            $fc->setCommande($commande);
            $fc->setDate(new \DateTime());
            $fc->setTotalHT($prixTotal);
            //+tva + reduc = totalTTC
            $this->em->persist($fc);

                
        $em->flush();
        $this->addFlash('success', 'Votre commande a été enregistrée!');
        $session->set("panier", array());
           return $this->redirectToRoute('home');
          

   }
       return $this->render('panier/commande.html.twig', [
           'form' => $form->createView(),
           'panier' =>$panier,
           'total' =>$total
           
       
       ]);
    } 
}
