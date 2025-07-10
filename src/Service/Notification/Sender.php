<?php

namespace App\Service\Notification;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Security\Core\User\UserInterface;

class Sender
{
    //Injecte le service Mailer dans Sender.
    public function  __construct(private readonly MailerInterface $mailer)
    {

    }
     public function sendNewUserNotificationToAdmin(UserInterface $user):void{
         //Pour tester
         file_put_contents('debug.txt',$user->getEmail());
         $message = new Email();
         $message->from('account@demo.fr')
             ->to('admin@demo.fr')
             ->subject('Nouveau utilisateur créé depuis le site Demo')
             ->html('<h1>Nouvel Utilisateur</h1>email: <strong> '.$user->getEmail().'</strong>');
         $this->mailer->send($message);
     }
}