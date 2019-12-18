<?php

namespace App\Controller;

use App\Entity\Livre;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

class PanierController extends AbstractController
{
    /**
     * @Route("/panier/", name="panier_liste")
     */
    public function liste(SessionInterface $session)
    {
        $repo = $this->getDoctrine()->getRepository(Livre::class);
        $panier = $session->get("panier", []);

        

        $livres = $repo->findById(array_keys($panier));
        $prixTotal = 0;
        $total = 0;

        foreach($livres as $item) {
            $prixTotal = $item->getPrix() + $item->getPrix()*$panier[$item->getId()];
            $total += $item->getPrix()*$panier[$item->getId()];
        }

        // dump($livres);
        // dump($panier);

        return $this->render('panier/index.html.twig', [
            "livres" => $livres,
            "panier" => $panier,
            "total" => $total
        ]);
    }

    /**
     * @Route("/panier_add/{id}", name="panier_add")
     */
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
       }
       
        $session->set("panier", $panier);

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
}
