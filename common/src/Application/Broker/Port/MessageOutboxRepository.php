<?php

namespace Common\Application\Broker\Port;

use Common\Application\Repository\HasOffsets;
use Common\Application\Repository\HasTransactions;

interface MessageOutboxRepository extends HasTransactions, HasOffsets
{

    /**
     * @param Message $message
     * @return void
     */
    public function save(Message $message): void;

    /**
     * @return MessageCollection
     */
    public function get(): MessageCollection;

    /**
     * @param string $id
     * @return Message
     */
    public function find(string $id): Message;

    /**
     * @return self
     */
    public function pending(): self;
}