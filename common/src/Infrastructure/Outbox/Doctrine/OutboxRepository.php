<?php

namespace Common\Infrastructure\Outbox\Doctrine;

use Common\Application\Outbox\OutboxStatus;
use Common\Application\Outbox\Port\OutboxRepository as OutboxRepositoryPort;
use Common\Domain\ValueObject\Exception\InvalidUuidException;
use Common\Domain\ValueObject\Uuid;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;

class OutboxRepository implements OutboxRepositoryPort
{

    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    /**
     * @param string $name
     * @param Uuid $eventId
     * @param Uuid $aggregateId
     * @param array $payload
     * @throws Exception
     * @throws InvalidUuidException
     */
    public function save(
        string $name,
        Uuid $eventId,
        Uuid $aggregateId,
        array $payload,
    ): void
    {
        $this->entityManager->getConnection()
            ->createQueryBuilder()
            ->insert('outbox')
            ->values([
                'id' => '?',
                'name' => '?',
                'event_id' => '?',
                'aggregate_id' => '?',
                'payload' => '?',
                'status' => '?',
            ])
            ->setParameter(0, Uuid::create()->toString())
            ->setParameter(1, $name)
            ->setParameter(2, $eventId->toString())
            ->setParameter(3, $aggregateId->toString())
            ->setParameter(4, json_encode($payload))
            ->setParameter(5, OutboxStatus::STARTED->value)
            ->executeQuery();
    }

    /**
     * @param Uuid $eventId
     * @return void
     * @throws Exception
     */
    public function complete(Uuid $eventId): void
    {
        $this->entityManager->getConnection()
            ->createQueryBuilder()
            ->update('outbox')
            ->set('status', '?')
            ->where('id = ?')
            ->setParameter(0, OutboxStatus::COMPLETED->value)
            ->setParameter(1, $eventId->toString()) // Предполагая, что $id - это идентификатор записи, которую нужно обновить
            ->executeQuery();
    }

    /**
     * @param Uuid $eventId
     * @return void
     * @throws Exception
     */
    public function fail(Uuid $eventId): void
    {
        $this->entityManager->getConnection()
            ->createQueryBuilder()
            ->update('outbox')
            ->set('status', '?')
            ->where('id = ?')
            ->setParameter(0, OutboxStatus::FAILED->value)
            ->setParameter(1, $eventId->toString()) // Предполагая, что $id - это идентификатор записи, которую нужно обновить
            ->executeQuery();
    }

    /**
     * @throws Exception
     */
    public function getUnpublishedMessages(int|null $limit = null): array
    {
        return $this->entityManager->getConnection()
            ->createQueryBuilder()
            ->select('*')
            ->from('outbox')
            ->where('status = ?')
            ->setParameter(0, OutboxStatus::STARTED->value)
            ->executeQuery()
            ->fetchAllAssociative();
    }
}