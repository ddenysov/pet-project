<?php

namespace Ride\Infrastructure\Projector\Doctrine;

use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Ride\Application\Projector\Port\RiderRequestAcceptedJoinToRideProjector;
use Ride\Domain\Event\RiderRequestAcceptedJoinToRide;
use Ride\Infrastructure\Persistence\Doctrine\Entity\Ride;
use Symfony\Component\Uid\Uuid;

class RideJoinRequestAcceptedProjector implements RiderRequestAcceptedJoinToRideProjector
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

    public function apply(RiderRequestAcceptedJoinToRide $event): void
    {
        $this->logger->info('Saving Ride Accepted to Join projection');

        $ride = $this->entityManager->find(Ride::class, Uuid::fromString($event->getAggregateId()->toString()));

        $ride->addRider($event->getRiderId()->toString());
        $this->entityManager->persist($ride);
        $this->entityManager->flush();

        $this->logger->info('Completed saving Ride Accepted To Join projection');
    }
}