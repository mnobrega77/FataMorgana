<?php
namespace App\Service;

use App\Repository\LivreRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\RequestStack;

class PanierService
{
    private $requestStack;
    private $lvRepo;
    private $security;
    private $uRepo;

    public function __construct(RequestStack $requestStack, LivreRepository $lvRepo, Security $security, UserRepository $uRepo)
    {
        $this->requestStack = $requestStack;
        $this->lvRepo=$lvRepo;
        $this->security=$security;
        $this->uRepo = $uRepo;
    }

    //add items to panier functionn
    public function addItems(int $id)
    {
        $session = $this->requestStack->getSession();
        $panier = $session->get('panier', []);
        if(!empty($panier[$id])){
            $panier[$id]++;
        }else{
            $panier[$id] = 1;
        }
        $session->set('panier', $panier);

    }
    //remove items to panier function
    public function removeItems(int $id)
    {
        $session = $this->requestStack->getSession();
        $panier = $session->get('panier', []);
        //if(!empty($panier[$id])){
            if ($panier[$id]>1) {
                $panier[$id]--;
                //dd($panier);
            }
            else {
                // dd($panier);
                unset($panier[$id]);

            }
        //}

        $session->set('panier', $panier);

    }

    //retriev all items
    public function getAllItems() : array
    {
        $session = $this->requestStack->getSession();
        $panier = $session->get('panier', []);
        $panierFinal = [];

//        foreach ($panier as $id => $quantity){
//            $panierFinal[] =[
//                "livre" => $this->lvRepo->find($id),
//                "quantity" => $quantity
//            ];
//        }

        $livres = $this->lvRepo->findById(array_keys($panier));
        $prixTotal = 0;
        $total = 0;

        foreach($livres as $item) {
            $prixTotal = $item->getPrix() + $item->getPrix()*$panier[$item->getId()];

            if ($this->security->getToken()->getUser()){
                $connectedUserEmail = $this->security->getToken()->getUser()->getUserIdentifier();
                $connectedUser = $this->uRepo->findOneBy(["email" => $connectedUserEmail]);

                if($connectedUser){
                    if($connectedUser->getClient()){
                        $coeff = $connectedUser->getClient()->getCoeff();
                        $item->prixapayer = ( $item->getPrix() / 2) *  $coeff;
                    }else{
                        $item->prixapayer = $item->getPrix();
                    }
                }else{
                    $item->prixapayer = $item->getPrix();
                }
            }

            $total += $item->prixapayer*$panier[$item->getId()];
        }


        return $panierFinal;

    }

    //count total
    public function getTotal() : float
    {
        $total = 0;
        foreach ($this->getAllItems() as $item){
            $total+= $item['livre']->getPrix() * $item['quantity'];
        }
        return $total;

    }

    //count total
    public function getAllQty() : int
    {
        $totalQty = 0;
        foreach ($this->getAllItems() as $item){
            $totalQty+= $item['quantity'];
        }
        return $totalQty;

    }

}