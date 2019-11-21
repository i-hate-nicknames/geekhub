<?php

namespace App\Services;

use App\Message\TelegramMessage;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\MessageBusInterface;
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
     * @var MessageBusInterface
     */
    private $bus;
    private $notificationsDisabled;

    /**
     * Notifier constructor.
     * @param string $adminMail
     * @param string $storeMail
     * @param $notificationsDisabled
     * @param MailerInterface $mailer
     * @param MessageBusInterface $bus
     */
    public function __construct(
        string $adminMail,
        string $storeMail,
        $notificationsDisabled,
        MailerInterface $mailer,
        MessageBusInterface $bus
    ) {
        $this->adminMail = $adminMail;
        $this->storeMail = $storeMail;
        $this->mailer = $mailer;
        $this->bus = $bus;
        $this->notificationsDisabled = $notificationsDisabled;
    }

    public function notify(string $text)
    {
        if (!empty($this->notificationsDisabled)) {
            return;
        }
        // todo: use Symfony\Component\Notifier\Chatter for sending,
        // instead of explicit message dispatch.
        $this->bus->dispatch(new TelegramMessage($text));
        $headers = (new Headers())
            ->addMailboxListHeader('From', [$this->storeMail])
            ->addMailboxListHeader('To', [$this->adminMail])
            ->addTextHeader('Subject', 'Store notification');
        $text = new TextPart($text);
        $email = new Message($headers, $text);
        $this->mailer->send($email);
    }
}
