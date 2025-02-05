<?php

namespace Common\Infrastructure\Broker\Doctrine;

use Common\Application\Broker\MessageChannel;
use Common\Application\Broker\Port\Message;
use Common\Application\Broker\MessageCollection;
use Doctrine\DBAL\Connection;

class MessageOutboxRepository implements \Common\Application\Broker\Port\MessageOutboxRepository
{
    const TABLE = 'message_outbox';

    protected static $created = [];

    private Connection $connection;
    private int        $limit  = 10;
    private int        $offset = 0;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function save(Message $message): void
    {
        $data = [
            'id'       => $message->getId(),
            'event_id' => $message->getEventId(),
            'name'     => $message->getName(),
            'payload'  => json_encode($message->getPayload()),
            'status'   => $message->getStatus(),
            'channel'  => $message->getChannel()->getName(),
        ];

        if ($message->getCreateAt() || in_array($message->getId(), self::$created)) {
            $data['created_at'] = $message->getCreateAt()->format('Y-m-d H:i:s');
            $this->connection->update(self::TABLE, $data, ['id' => $message->getId()]);
        } else {
            $data['created_at'] = date('Y-m-d H:i:s');
            $this->connection->insert(self::TABLE, $data);
        }

        self::$created[] = $message->getId();
    }

    public function get(): MessageCollection
    {
        $messages = $this->connection->fetchAllAssociative(
            'SELECT * FROM ' . self::TABLE . ' LIMIT :limit OFFSET :offset',
            ['limit' => $this->limit, 'offset' => $this->offset]
        );

        return new MessageCollection(array_map(function ($value) {
            return [
                'id'        => $value['id'],
                'event_id'  => $value['event_id'],
                'name'      => $value['name'],
                'payload'   => json_decode($value['payload'], true),
                'status'    => $value['status'],
                'createdAt' => new \DateTime($value['created_at']),
                'channel'   => new MessageChannel($value['channel']),
            ];
        }, $messages));
    }

    public function find(string $id): Message
    {
        $message = $this->connection->fetchAssociative(
            'SELECT * FROM ' . self::TABLE . ' WHERE id = :id',
            ['id' => $id]
        );

        if (!$message) {
            throw new \RuntimeException("Message not found");
        }
        return new \Common\Application\Broker\Message(...[
            'id'       => $message['id'],
            'event_id' => $message['event_id'],
            'name'     => $message['name'],
            'payload'  => json_decode($message['payload'], true),
            'status'   => $message['status'],
            'channel'  => new MessageChannel($message['channel']),
        ]);
    }

    public function pending(): self
    {
        $this->connection->executeQuery(
            'SELECT * FROM ' . self::TABLE . ' WHERE status = :status',
            ['status' => 'pending']
        );

        return $this;
    }

    public function startTransaction(): void
    {
        $this->connection->beginTransaction();
    }

    public function commit(): void
    {
        $this->connection->commit();
    }

    public function rollback(): void
    {
        $this->connection->rollBack();
    }

    public function limit(int $number): static
    {
        $this->limit = $number;
        return $this;
    }

    public function offset(int $number): static
    {
        $this->offset = $number;
        return $this;
    }
}