<?php

namespace App\Message;

class TelegramMessage
{
    /**
     * @var string
     */
    private $message;

    /**
     * TelegramMessage constructor.
     * @param string $message
     */
    public function __construct(string $message)
    {
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }
}
