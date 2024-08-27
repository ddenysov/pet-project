<?php

namespace Ride\Infrastructure\Projector\Doctrine;

use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Ride\Domain\Event\RideEvent;
use Ride\Infrastructure\Persistence\Doctrine\Entity\Ride;
use Symfony\Component\Uid\Uuid;
use Ride\Domain\Event\HealthCheckOk;
use Ride\Infrastructure\Persistence\Doctrine\Entity\HealthCheck;

class RideProjector implements \Ride\Application\Projector\Port\RideProjector
{

    public function __construct(
        private EntityManagerInterface $entityManager,
        private LoggerInterface $logger,
    )
    {
    }

    public function apply(RideEvent $event): void
    {
        $this->logger->info('Ride saving projection: ' . $event->getAggregateId()->toString());

        $dbEntity = new Ride();
        $dbEntity->setId(Uuid::fromString($event->getAggregateId()->toString()));
        $dbEntity->setName($event->getRideName()->toString());
        $dbEntity->setCreatedAt(new DateTime());
        $dbEntity->setStartDateTime(new DateTime());
        $dbEntity->setEndDateTime(new DateTime());
        $dbEntity->setUserId(Uuid::v4());

        $this->entityManager->persist($dbEntity);
        $this->entityManager->flush();
        $this->logger->info('Ride projection saved: ' . $dbEntity->getId()->toString(), $event->payload());
    }
}