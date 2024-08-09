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
        private readonly Outbox                 $outbox,
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
            ->setParameter(4, 1)
            ->setParameter(5, (new \DateTime())->format('Y-m-d H:i:s'))
            ->executeQuery();

        return $this;
    }
}