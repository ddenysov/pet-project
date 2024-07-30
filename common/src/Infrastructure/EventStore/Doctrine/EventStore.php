<?php

namespace Common\Infrastructure\EventStore\Doctrine;

use Common\Application\EventStore\Port\EventStore as EventStorePort;
use Common\Domain\Event\Port\Event;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Throwable;

class EventStore implements EventStorePort
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    )
    {
    }

    /**
     * @throws Throwable
     */
    public function append(Event $event): EventStorePort
    {
        $this->entityManager->getConnection()
            ->createQueryBuilder()
            ->insert('event_store')
            ->values([
                'id' => '?',
                'aggregate_id' => '?',
                'payload'      => '?',
                'version'      => '?',
            ])
            ->setParameter(0, $event->getId()->toString())
            ->setParameter(1, $event->getAggregateId()->toString())
            ->setParameter(2, json_encode($event->toArray()))
            ->setParameter(3, 1)
            ->executeQuery();

        return $this;
    }
}