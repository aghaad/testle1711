<?php


namespace App\Services;

use Symfony\Component\Templating\EngineInterface;
use App\Entity\Commande;

class Mailer
{
    private $mailer;
    private $from = 'no-reply@louvre.fr';
    private $reply = 'contact@louvre.fr';
    private $name = 'Musée du Louvre - Billetterie';
    private $twig;

    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;

    }

    public function sendMessage($to, $subject, $body)
    {
        $mail = new \Swift_Message();

        $mail
            ->setFrom(array($this->from => $this->name))
            ->setTo($to)
            ->setSubject($subject)
            ->setBody($body)
            ->setReplyTo(array($this->reply => $this->name))
            ->setContentType('text/html');

        $this->mailer->send($mail);
    }

    public function sendOrderSuccess(Commande $commande, $renderView)
    {
        $subject = "[Musée du Louvre - Billetterie] Votre commande a été validée.";

        $to = $commande->getEmail();
        $body = $renderView;
        $this->sendMessage($to, $subject, $body);
    }

    public function sendEmail($mail)
    {
        $message = (new \Swift_Message('Récapitulatif de votre commande - Musée du Louvre'))
            ->setFrom('send@example.com')
            ->setTo($mail)
            ->setBody('You should see me from the profiler!');

        $this->mailer->send($message);

        // ...
    }
}
