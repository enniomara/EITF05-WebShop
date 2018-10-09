<?php

namespace App\Classes\Models;

class FlashMessage
{
    /**
     * @var string
     */
    private $message;
    /**
     * @var int
     */
    private $type;

    public function __construct(string $message, int $type)
    {
        $this->message = $message;
        $this->type = $type;
    }

    /**
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }
}
