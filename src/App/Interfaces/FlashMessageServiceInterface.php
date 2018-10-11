<?php

namespace App\Interfaces;

use App\Classes\Models\FlashMessage;

interface FlashMessageServiceInterface
{
    const ERROR = 0;
    const WARNING = 1;
    const SUCCESS = 2;
    const INFO = 3;

    public function add(string $message, int $type = FlashMessageServiceInterface::INFO);

    /**
     * Clear a given message type. E.g. self::ERROR.
     *
     * @param int $type
     * @return mixed
     */
    public function clear(int $type): void;

    /**
     * See if there are messages of a given type stored.
     *
     * @param int|null $type If type is null, all messages will be counted.
     * @return bool
     */
    public function hasMessages(int $type = null): bool;

    /**
     * Get a list of errors of type $type and remove them from the storage.
     *
     * @param int $type
     * @return FlashMessage[]
     */
    public function getMessage(int $type): array;

    /**
     * Get a lost of all messages and remove them from the storage.
     *
     * @return array
     */
    public function getMessages(): array;
}
