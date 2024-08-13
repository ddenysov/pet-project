<?php

namespace Common\Infrastructure\EventStore\Doctrine;

use Common\Application\EventStore\EventStore as BaseEventStore;
use Common\Application\EventStore\Port\EventStore as EventStorePort;
use Common\Application\Outbox\Port\Outbox;
use Common\Application\Serializer\Event\EventSerializer;
use Common\Domain\Event\EventStream;
use Common\Domain\ValueObject\Uuid;
use Doctrine\ORM\EntityManagerInterface;
use Iam\Infrastructure\Persistence\Doctrine\Entity\EventStore as EventStoreEntity;
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
        private readonly LoggerInterface $logger,
        private readonly EventSerializer $eventSerializer
    )
    {
        parent::__construct($this->outbox, $logger);
    }

    protected function save(\Common\Domain\Event\Event $event)
    {
        $version = $this->getLastVersion($event->getAggregateId());
        $version++;

        $this->entityManager->getConnection()
            ->createQueryBuilder()
            ->insert('event_store')
            ->values([
                'id'           => '?',
                'name'         => '?',
                'aggregate_id' => '?',
                'payload'      => '?',
                'version'      => '?',
                'created_at'   => '?',
            ])
            ->setParameter(0, $event->getId()->toString())
            ->setParameter(1, $event->getName())
            ->setParameter(2, $event->getAggregateId()->toString())
            ->setParameter(3, json_encode($event->toArray()))
            ->setParameter(4, $version)
            ->setParameter(5, (new \DateTime())->format('Y-m-d H:i:s'))
            ->executeQuery();


        return $this;
    }

    /**
     * @param Uuid $aggregateId
     * @return int
     */
    private function getLastVersion(Uuid $aggregateId): int
    {
        $version = $this->entityManager->createQueryBuilder()
            ->select('MAX(e.version)')
            ->from(EventStoreEntity::class, 'e')
            ->where('e.aggregateId = :aggregateId')
            ->setParameter('aggregateId', $aggregateId->toString())
            ->getQuery()
            ->getSingleScalarResult();

        return $version ?? 0;
    }

    public function getEventStream(Uuid $id): EventStream
    {
        $events = $this->entityManager->createQueryBuilder()
            ->select('e')
            ->from(EventStoreEntity::class, 'e')
            ->where('e.aggregateId = :aggregateId')
            ->setParameter('aggregateId', $id->toString())
            ->getQuery()
            ->getResult();

        $eventStream = new EventStream();

        foreach ($events as $event) {
            $eventStream[] = $this->eventSerializer->deserialize(
                name: $event->getName(),
                payload: $event->getPayload(),
            );
        }

        return $eventStream;
    }
}