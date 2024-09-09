<?php

namespace Ride\Infrastructure\Projector\Doctrine;

use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Ride\Application\Projector\Port\RiderJoinedProjector;
use Ride\Domain\Event\RiderJoinedToRide;
use Ride\Infrastructure\Persistence\Doctrine\Entity\Ride;
use Symfony\Component\Uid\Uuid;

class RideJoinedProjector implements RiderJoinedProjector
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

    public function apply(RiderJoinedToRide $event): void
    {
        $this->logger->info('Saving RideUpdated projection');

        $ride = $this->entityManager->find(Ride::class, Uuid::fromString($event->getAggregateId()->toString()));

        $ride->addRider($event->getRiderId()->toString());
        $this->entityManager->persist($ride);
        $this->entityManager->flush();

        $this->logger->info('Completed saving RideUpdated projection');
    }
}