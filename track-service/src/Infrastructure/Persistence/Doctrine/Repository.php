<?php

namespace Track\Infrastructure\Persistence\Doctrine;

use Common\Application\EventStore\Port\EventStore;
use Common\Application\Outbox\Port\Outbox;
use Doctrine\ORM\EntityManagerInterface;

abstract class Repository
{
    /**
     * @param EntityManagerInterface $entityManager
     * @param EventStore $eventStore
     * @param Outbox $outbox
     */
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly EventStore $eventStore,
        private readonly Outbox $outbox,
    )
    {
    }

    public function getEntityManager(): EntityManagerInterface
    {
        return $this->entityManager;
    }

    public function getEventStore(): EventStore
    {
        return $this->eventStore;
    }

    public function getOutbox(): Outbox
    {
        return $this->outbox;
    }
}