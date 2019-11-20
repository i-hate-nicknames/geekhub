<?php

namespace App\Message;

use Exception;
use http\Exception\RuntimeException;
use Psr\Log\LoggerInterface;
use Symfony\Component\Mailer\Exception\TransportException;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Mime\Header\Headers;
use Symfony\Component\Mime\Message;
use Symfony\Component\Mime\Part\TextPart;

class ProductNotificationHandler implements MessageHandlerInterface
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var MailerInterface
     */
    private $mailer;
    /**
     * @var string
     */
    private $adminMail;
    /**
     * @var string
     */
    private $storeMail;

    /**
     * ProductNotificationHandler constructor.
     * @param string $adminMail
     * @param string $storeMail
     * @param LoggerInterface $logger
     * @param MailerInterface $mailer
     */
    public function __construct(string $adminMail, string $storeMail, LoggerInterface $logger, MailerInterface $mailer)
    {
        $this->logger = $logger;
        $this->mailer = $mailer;
        $this->adminMail = $adminMail;
        $this->storeMail = $storeMail;
    }

    public function __invoke(ProductNotification $message)
    {
        // todo: send mail :DDD
        $headers = (new Headers())
            ->addMailboxListHeader('From', [$this->storeMail])
            ->addMailboxListHeader('To', [$this->adminMail])
            ->addTextHeader('Subject', 'Store notification');
        $text = new TextPart($message->getText());
        $email = new Message($headers, $text);
        $this->mailer->send($email);
    }
}
