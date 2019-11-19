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
     * @var string
     */
    private $mailAddress;
    /**
     * @var MailerInterface
     */
    private $mailer;

    /**
     * ProductNotificationHandler constructor.
     * @param string $mailAddress
     * @param LoggerInterface $logger
     * @param MailerInterface $mailer
     */
    public function __construct(string $mailAddress, LoggerInterface $logger, MailerInterface $mailer)
    {
        $this->logger = $logger;
        $this->mailAddress = $mailAddress;
        $this->mailer = $mailer;
    }

    public function __invoke(ProductNotification $message)
    {
        // todo: send mail :DDD
        $headers = (new Headers())
            ->addMailboxListHeader('From', [$this->mailAddress])
            ->addMailboxListHeader('To', [$this->mailAddress])
            ->addTextHeader('Subject', 'Store notification');
        $text = new TextPart($message->getText());
        $email = new Message($headers, $text);
        try {
            $this->mailer->send($email);
        } catch (HandlerFailedException $exception) {
            $this->logger->error('I am very sorry dear friend your message is no more');
        }
    }
}
