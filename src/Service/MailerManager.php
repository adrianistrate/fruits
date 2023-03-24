<?php

namespace App\Service;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

final class MailerManager
{
    public function __construct(private readonly MailerInterface $mailer)
    {

    }

    public function sendFruitsFetchedEmail(int $nbrNewFruits): void
    {
        $email = (new TemplatedEmail())
            ->to(new Address('admin@fetchfruits.com'))
            ->subject('Fruits fetched')
            ->htmlTemplate('emails/fruits_fetched.html.twig')
            ->context([
                'nbrNewFruits' => $nbrNewFruits,
            ]);

        $this->mailer->send($email);
    }
}
