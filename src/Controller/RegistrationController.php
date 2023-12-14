<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Utilisateur;
use App\Form\RegistrationFormType;
use App\Form\RegistrationType;
use App\Repository\UtilisateurRepository;
use App\Security\EmailVerifier;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class RegistrationController extends AbstractController
{
    private $em;
    private $passwordHasher;
    private $mailer;

    public function __construct(EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher, MailerInterface $mailer)
    {
        $this->em = $em;
        $this->passwordHasher = $passwordHasher;
        $this->mailer = $mailer;
    }

    #[Route('/inscription', name: 'app_inscription')]

    public function registration(Request $request, MailerInterface $mailer)
    {
        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $this->passwordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );


            $this->em->persist($user);
            $this->em->flush();

            // Sending an email to the new user

            $email = (new TemplatedEmail())
                ->from('mn@fatamorgana.com')
                ->to(new Address($user->getEmail(), $user->getUsername()))
                ->subject("Bienvenue sur notre site!")
                // ->text("Nous sommes heureux de vous connaître, {$user->getUsername()}!");
                ->htmlTemplate('emails/reg_confirm.html.twig');
            $this->mailer->send($email);

            return $this->redirectToRoute('app_login');

        }
        return $this->render('security/registration.html.twig', [
            'form' => $form->createView()
        ]);

        // dump($user);



    }


}
