<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;



class EmailController extends AbstractController
{
    #[Route('/email', name: 'app_email')]
    public function index(): Response
    {    return $this->render('email/index.html.twig');

    }

    #[Route('/app', name: 'app')]
    public function envoyerEmail(Request $request, MailerInterface $mailer)
    {
        if ($request->isMethod('POST')) {
            $expediteur = $request->request->get('expediteur');
            $destinataire = 'benhamidasarra8@gmail.com';
            $sujet = $request->request->get('sujet');
            $message = $request->request->get('message');

            $email = (new Email())
                ->from($expediteur)
                ->to($destinataire)
                ->subject($sujet)
                ->text($message);

            $mailer->send($email);

            return new Response('E-mail envoyé !');
        }

        return $this->render('email/index.html.twig');
    }
}
