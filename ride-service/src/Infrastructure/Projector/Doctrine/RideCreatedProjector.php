<?php

namespace Ride\Infrastructure\Projector\Doctrine;

use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Ride\Application\Projector\Port\RideCreatedProjector as RideCreatedProjectorPort;
use Ride\Domain\Event\RideCreated;
use Ride\Infrastructure\Persistence\Doctrine\Entity\Ride;
use Symfony\Component\Uid\Uuid;

final readonly class RideCreatedProjector implements RideCreatedProjectorPort
{
    /**
     * @param EntityManagerInterface $entityManager
     * @param LoggerInterface $logger
     */
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly LoggerInterface        $logger,
    )
    {
    }

    public function apply(RideCreated $event): void
    {
        $this->logger->info('Ride creating projection: ' . $event->getAggregateId()->toString());

        $dbEntity = new Ride();
        $dbEntity->setId(Uuid::fromString($event->getAggregateId()->toString()));
        $dbEntity->setName($event->getName()->toString());
        $dbEntity->setOrganizerId(Uuid::fromString($event->getOrganizerId()->toString()));
        $dbEntity->setCreatedAt(new DateTime());
        $dbEntity->setStartDateTime(new DateTime());
        $dbEntity->setEndDateTime(new DateTime());

        $this->entityManager->persist($dbEntity);
        $this->entityManager->flush();
        $this->logger->info('Ride projection created: ' . $dbEntity->getId()->toString(), $event->payload());
    }
}