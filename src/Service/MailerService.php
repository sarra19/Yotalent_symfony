<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

class MailerService
{
    
    private $mailer;
    
    
    public function __construct( MailerInterface $mailer)
     {
        
        $this->mailer=$mailer;
     }
    
    public function sendEmail(    $to ): void
    {
        
        $email = (new Email())
            ->from('razisniha@gmail.com')
            ->to($to)
            ->subject('Ton rendez-vous et bien enrigistre')
            ->text('See Twig integration for better HTML integration!');
             
            $this->mailer->send($email);
      
        // ...
    }
}