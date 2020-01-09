<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Client;
use App\Repository\ClientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Psr\Log\LoggerInterface;

/**
 * @IsGranted("ROLE_USER")
 */

class AccountController extends AbstractController

{
    /**
     * @Route("/account", name="app_account")
     */
    public function index(LoggerInterface $logger, ClientRepository $repo)
    {
        $client = $this->getUser()->getClient();
        // dd($this->getUser()->getUsername());
        $logger->debug('Checking account page for '.$this->getUser()->getEmail());
        //$cmmd = $repo->findById($client->getId());

        return $this->render('account/index.html.twig', [
            
            'commandes' => $client->getCommandes()
        ]);
    }

    
}
