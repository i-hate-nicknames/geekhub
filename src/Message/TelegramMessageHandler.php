<?php

namespace App\Message;

use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Notifier\Message\ChatMessage;
use Symfony\Component\Notifier\Transport\TransportInterface;

//TODO: once there is a default handler for ChatMessage, this class
// should be removed and ChatMessage instances should be just dispatched onto the bus
class TelegramMessageHandler implements MessageHandlerInterface
{
    /**
     * @var TransportInterface
     */
    private $transport;

    /**
     * TelegramMessageHandler constructor.
     * @param TransportInterface $transport
     */
    public function __construct(TransportInterface $transport)
    {
        $this->transport = $transport;
    }

    public function __invoke(TelegramMessage $msg)
    {
        $this->transport->send(new ChatMessage($msg->getMessage()));
    }
}
