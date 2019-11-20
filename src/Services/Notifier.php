<?php

namespace App\Services;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Header\Headers;
use Symfony\Component\Mime\Message;
use Symfony\Component\Mime\Part\TextPart;

class Notifier
{
    /**
     * @var string
     */
    private $adminMail;
    /**
     * @var string
     */
    private $storeMail;

    /**
     * @var MailerInterface
     */
    private $mailer;

    /**
     * Notifier constructor.
     * @param string $adminMail
     * @param string $storeMail
     * @param MailerInterface $mailer
     */
    public function __construct(string $adminMail, string $storeMail, MailerInterface $mailer)
    {
        $this->adminMail = $adminMail;
        $this->storeMail = $storeMail;
        $this->mailer = $mailer;
    }

    public function notify(string $text)
    {
        $headers = (new Headers())
            ->addMailboxListHeader('From', [$this->storeMail])
            ->addMailboxListHeader('To', [$this->adminMail])
            ->addTextHeader('Subject', 'Store notification');
        $text = new TextPart($text);
        $email = new Message($headers, $text);
        $this->mailer->send($email);
    }
}
