<?php

namespace Track\Infrastructure\Projector\Doctrine;

use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Uid\Uuid;
use Track\Domain\Event\HealthCheckOk;
use Track\Domain\Event\TrackCreated;
use Track\Infrastructure\Persistence\Doctrine\Entity\HealthCheck;
use Track\Infrastructure\Persistence\Doctrine\Entity\Track;

class TrackCreatedProjector implements \Track\Application\Projector\Port\TrackCreatedProjector
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
        $dbEntity->setPath($event->trackPath->getPath());
        $dbEntity->setLength($event->trackPath->getLength());

        $this->entityManager->persist($dbEntity);
        $this->entityManager->flush();
        $this->logger->info('Healthcheck projection saved: ' . $dbEntity->getId()->toString(), $event->payload());
    }
}