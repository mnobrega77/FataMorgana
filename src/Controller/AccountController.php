<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Client;
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
    public function index(LoggerInterface $logger)
    {
        // dd($this->getUser()->getUsername());
        $logger->debug('Checking account page for '.$this->getUser()->getEmail());


        return $this->render('account/index.html.twig', [
            'controller_name' => 'AccountController',
        ]);
    }

    
}
