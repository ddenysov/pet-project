<?php

namespace Common\Infrastructure\Outbox\Doctrine;

use Common\Application\Outbox\OutboxStatus;
use Common\Application\Outbox\Port\OutboxRepository as OutboxRepositoryPort;
use Common\Domain\ValueObject\Exception\InvalidUuidException;
use Common\Domain\ValueObject\Uuid;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use User\Domain\Model\ValueObject\DateTime;

class OutboxRepository implements OutboxRepositoryPort
{

    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    /**
     * @param Uuid $eventId
     * @param string $name
     * @param array $payload
     * @throws Exception
     * @throws InvalidUuidException
     */
    public function save(
        Uuid $eventId,
        string $name,
        array $payload,
    ): void
    {
        $this->entityManager->getConnection()
            ->createQueryBuilder()
            ->insert('outbox')
            ->values([
                'event_name' => '?',
                'event_id' => '?',
                'payload' => '?',
                'status' => '?',
                'created_at' => '?',
            ])
            ->setParameter(0, $name)
            ->setParameter(1, $eventId->toString())
            ->setParameter(2, json_encode($payload))
            ->setParameter(3, OutboxStatus::STARTED->value)
            ->setParameter(4, (new \DateTime())->format('Y-m-d H:i:s'))
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
            ->where('event_id = ?')
            ->setParameter(0, OutboxStatus::COMPLETED->value)
            ->setParameter(1, $eventId->toString())
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