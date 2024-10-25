<?php

namespace Common\Infrastructure\EventStore\Doctrine;

use Common\Application\EventStore\EventRouter;
use Common\Application\EventStore\EventStore as BaseEventStore;
use Common\Application\EventStore\Port\EventStore as EventStorePort;
use Common\Application\Outbox\Port\Outbox;
use Common\Application\Serializer\Event\EventSerializer;
use Common\Domain\Event\Event;
use Common\Domain\Event\EventStream;
use Common\Domain\ValueObject\Uuid;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Common\Infrastructure\Persistence\Doctrine\Entity\EventStore as EventStoreEntity;
use Psr\Log\LoggerInterface;

class EventStore extends BaseEventStore implements EventStorePort
{
    /**
     * @param EntityManagerInterface $entityManager
     * @param Outbox $outbox
     * @param LoggerInterface $logger
     */
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly Outbox                 $outbox,
        private readonly LoggerInterface        $logger,
        private readonly EventSerializer        $eventSerializer,
        EventRouter $eventRouter,
    )
    {
        parent::__construct($this->outbox, $eventRouter, $logger);
    }

    protected function save(Event $event): void
    {
        $version = $this->getLastVersion($event->getAggregateId());
        $version++;

        $this->entityManager->getConnection()
            ->createQueryBuilder()
            ->insert('event_store')
            ->values([
                'event_id'     => '?',
                'event_name'   => '?',
                'aggregate_id' => '?',
                'payload'      => '?',
                'version'      => '?',
                'created_at'   => '?',
            ])
            ->setParameter(0, $event->getEventId()->toString())
            ->setParameter(1, $event::getEventName())
            ->setParameter(2, $event->getAggregateId()->toString())
            ->setParameter(3, json_encode($event->toArray()))
            ->setParameter(4, $version)
            ->setParameter(5, (new DateTime())->format('Y-m-d H:i:s'))
            ->executeQuery();
    }

    /**
     * @param Uuid $aggregateId
     * @return int
     */
    private function getLastVersion(Uuid $aggregateId): int
    {
        $connection = $this->entityManager->getConnection();

        $version = $connection->createQueryBuilder()
            ->select('MAX(e.version)')
            ->from('event_store', 'e')  // предполагаем, что таблица называется 'event_store'
            ->where('e.aggregate_id = :aggregateId')
            ->setParameter('aggregateId', $aggregateId->toString())
            ->executeQuery()
            ->fetchOne();

        return $version ?? 0;
    }

    public function getEventStream(Uuid $id, string $entityClass): EventStream
    {
        $events = $this->entityManager->createQueryBuilder()
            ->select('e')
            ->from($entityClass, 'e')
            ->where('e.aggregateId = :aggregateId')
            ->setParameter('aggregateId', $id->toString())
            ->getQuery()
            ->getResult();

        $eventStream = new EventStream();

        foreach ($events as $event) {
            $eventStream[] = $this->eventSerializer->deserialize(
                name: $event->getEventName(),
                payload: $event->getPayload(),
            );
        }

        return $eventStream;
    }
}