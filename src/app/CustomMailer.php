<?php

namespace App;

use Symfony\Component\Mailer\Envelope;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\RawMessage;

class CustomMailer  implements MailerInterface
{
    protected Transport\TransportInterface $transport;

    public function __construct(protected string $dsn)
    {
        //set up the transporter
        $this->transport=Transport::fromDsn($dsn);
    }

    public function send(RawMessage $message, Envelope $envelope = null): void
    {
        $this->transport->send($message,$envelope);

    }
}