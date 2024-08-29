<?php

namespace Ride\Infrastructure\Projector\Doctrine;

use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Ride\Application\Projector\Port\RideUpdatedProjector as RideUpdatedProjectorPort;
use Ride\Domain\Event\RideUpdated;
use Ride\Infrastructure\Persistence\Doctrine\Entity\Ride;
use Symfony\Component\Uid\Uuid;

class RideUpdatedProjector implements RideUpdatedProjectorPort
{
    /**
     * @param EntityManagerInterface $entityManager
     * @param LoggerInterface $logger
     */
    public function __construct(
        private EntityManagerInterface $entityManager,
        private LoggerInterface $logger,
    )
    {
    }

    public function apply(RideUpdated $event): void
    {
        $this->logger->info('Saving RideUpdated projection');

        $ride = $this->entityManager->find(Ride::class, Uuid::fromString($event->getAggregateId()->toString()));
        $ride->setName($event->getRideName()->toString());
        $this->entityManager->persist($ride);
        $this->entityManager->flush();

        $this->logger->info('Completed saving RideUpdated projection');
    }
}