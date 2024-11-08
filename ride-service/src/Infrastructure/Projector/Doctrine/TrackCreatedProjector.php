<?php

namespace Ride\Infrastructure\Projector\Doctrine;

use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Ride\Domain\Event\TrackCreated;
use Ride\Infrastructure\Persistence\Doctrine\Entity\Track;
use Symfony\Component\Uid\Uuid;

class TrackCreatedProjector implements \Ride\Application\Projector\Port\TrackCreatedProjector
{

    public function __construct(
        private EntityManagerInterface $entityManager,
        private LoggerInterface $logger,
    )
    {
    }

    public function apply(TrackCreated $event): void
    {
        $dbEntity = new Track();
        $dbEntity->setId(Uuid::fromString($event->getAggregateId()->toString()));
        $dbEntity->setName($event->trackName->toString());
        $dbEntity->setOwnerId(Uuid::fromString($event->ownerId->toString()));
        $dbEntity->setLength($event->trackPath->getLength());

        $this->entityManager->persist($dbEntity);
        $this->entityManager->flush();
        $this->logger->info('Healthcheck projection saved: ' . $dbEntity->getId()->toString(), $event->payload());
    }
}