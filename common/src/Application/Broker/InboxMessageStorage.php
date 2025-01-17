<?php

namespace Common\Application\Broker;

use Common\Application\Broker\Port\Message;
use Common\Application\Broker\Port\MessageBuffer;
use Common\Application\Storage\Port\Storage;

class InboxMessageStorage implements \Common\Application\Broker\Port\InboxMessageStorage
{
    private Storage $storage;

    /**
     * @param Storage $storage
     */
    public function __construct(Storage $storage)
    {
        $this->storage = $storage;
    }

    #[\Override] public function find(string $id): Message
    {
        $data = $this->storage->find($id);

        return new \Common\Application\Broker\Message(
            $data['id'],
            $data['payload'],
            $data['status'],
            $data['created_at'],
        );
    }

    #[\Override] public function store(Message $message): void
    {
        $this->storage->store([
            'id' => $message->getId(),
            'payload' => $message->getPayload(),
            'status' => $message->getStatus(),
            'created_at' => $message->getCreateAt(),
        ]);
    }

    #[\Override] public function get(): MessageBuffer
    {
        // TODO: Implement get() method.
    }
}