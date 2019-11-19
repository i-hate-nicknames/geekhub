<?php

namespace App\Message;

use Exception;
use http\Exception\RuntimeException;
use Psr\Log\LoggerInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

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
        $this->logger->info($message->getText() . ' :DDDD');
    }
}
