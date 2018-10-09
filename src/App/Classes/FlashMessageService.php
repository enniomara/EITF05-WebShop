<?php

namespace App\Classes;

use App\Classes\Models\FlashMessage;
use App\Interfaces\FlashMessageServiceInterface;
use App\Interfaces\SessionManagerInterface;

class FlashMessageService implements FlashMessageServiceInterface
{
    /**
     * @var SessionManagerInterface
     */
    protected $sessionManager;

    protected $flashStorageKeyName = 'flashMessages';

    protected const DEFAULT_STORAGE_LAYOUT = [
        FlashMessageServiceInterface::ERROR => [],
        FlashMessageServiceInterface::WARNING => [],
        FlashMessageServiceInterface::SUCCESS => [],
        FlashMessageServiceInterface::INFO => []
    ];

    public function __construct(SessionManagerInterface $sessionManager)
    {
        $this->sessionManager = $sessionManager;

        if (false === $this->sessionManager->has($this->flashStorageKeyName)) {
            $this->sessionManager->put($this->flashStorageKeyName, self::DEFAULT_STORAGE_LAYOUT);
        }
    }

    /**
     * @inheritdoc
     */
    public function add(string $message, int $type = FlashMessageServiceInterface::INFO)
    {
        $flashMessages = $this->sessionManager->get($this->flashStorageKeyName);
        $flashMessages[$type][] = $message;
        $this->sessionManager->put($this->flashStorageKeyName, $flashMessages);
    }

    /**
     * @inheritdoc
     */
    public function clear(int $type): void
    {
        // TODO: Implement clear() method.
        $flashStorage = $this->sessionManager->get($this->flashStorageKeyName);
        $flashStorage[$type] = self::DEFAULT_STORAGE_LAYOUT[$type];
        $this->sessionManager->put($this->flashStorageKeyName, $flashStorage);
    }

    /**
     * @inheritdoc
     */
    public function hasMessages(int $type = null): bool
    {
        if ($type !== null) {
            return !empty($this->sessionManager->get($this->flashStorageKeyName)[$type]);
        }

        $flashMessages = $this->sessionManager->get($this->flashStorageKeyName);
        foreach (self::DEFAULT_STORAGE_LAYOUT as $flashStorageType => $value) {
            // Return true when the first found message is found
            if (!empty($flashMessages[$flashStorageType])) {
                return true;
            }
        }

        return false;
    }

    /**
     * @inheritdoc
     */
    public function getMessage(int $type): array
    {
        $messages = [];

        $flashMessages = $this->sessionManager->get($this->flashStorageKeyName);

        foreach ($flashMessages[$type] as $message) {
            $messages[] = $this->buildFlashMessage($message, $type);
        }
        $this->clear($type);

        return $messages;
    }

    protected function buildFlashMessage(string $message, int $type): FlashMessage
    {
        return new FlashMessage($message, $type);
    }
}
