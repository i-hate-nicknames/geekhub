<?php


namespace App\Services;


use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Header\Headers;
use Symfony\Component\Mime\Message;
use Symfony\Component\Mime\Part\TextPart;
use function var_export;

class Notifier
{
    /**
     * @var string
     */
    private $mailAddress;
    /**
     * @var MailerInterface
     */
    private $mailer;

    /**
     * Notifier constructor.
     * @param MailerInterface $mailer
     */
    public function __construct(string $mailAddress, MailerInterface $mailer)
    {
        $this->mailAddress = $mailAddress;
        $this->mailer = $mailer;
    }

    public function notify(string $msg)
    {
        $this->notifyEmail($msg);
        // todo: notify in telegram
    }

    private function notifyEmail(string $msg)
    {
        $headers = (new Headers())
            ->addMailboxListHeader('From', [$this->mailAddress])
            ->addMailboxListHeader('To', [$this->mailAddress])
            ->addTextHeader('Subject', 'Store notification');
        $text = new TextPart($msg);
        $email = new Message($headers, $text);
        $this->mailer->send($email);
    }
}
