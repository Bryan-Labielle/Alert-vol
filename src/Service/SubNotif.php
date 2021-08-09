<?php

namespace App\Service;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

class SubNotif
{
    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendNotifMessageMail($recipient, $signalement)
    {
        $email = (new TemplatedEmail())
            ->from(new Address('contact@alertvol.fr', 'Alert\'Vol'))
            ->to($recipient->getEmail())
            ->subject('Notification de nouveau message')
            ->htmlTemplate('email/message-mail.html.twig')
            ->context(['signalement' => $signalement]);

        $this->mailer->send($email);
    }

    public function sendNotifSignalementMail($recipient, $signalement)
    {
        $email = (new TemplatedEmail())
            ->from(new Address('contact@alertvol.fr', 'Alert\'Vol'))
            ->to($recipient->getEmail())
            ->subject('Notification de nouveau signalement')
            ->htmlTemplate('email/signalement-mail.html.twig')
            ->context(['signalement' => $signalement]);

        $this->mailer->send($email);
    }
}
