<?php

namespace Common\Infrastructure\EventStore\Doctrine;

use Common\Application\EventStore\EventStore as BaseEventStore;
use Common\Application\EventStore\Port\EventStore as EventStorePort;
use Common\Application\Outbox\Port\Outbox;
use Doctrine\ORM\EntityManagerInterface;

class EventStore extends BaseEventStore implements EventStorePort
{
    /**
     * @param EntityManagerInterface $entityManager
     * @param Outbox $outbox
     */
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly Outbox $outbox,
    )
    {
        parent::__construct($this->outbox);
    }

    protected function save(\Common\Domain\Event\Event $event)
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