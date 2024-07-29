<?php

namespace Iam\Infrastructure\Persistence\Doctrine;

use Common\Application\EventStore\Port\EventStore;
use Doctrine\ORM\EntityManagerInterface;

abstract class Repository
{
    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly EventStore $eventStore
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
}