<?php

namespace Ride\Infrastructure\Projector\Doctrine;

use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Uid\Uuid;
use Ride\Domain\Event\HealthCheckOk;
use Ride\Infrastructure\Persistence\Doctrine\Entity\HealthCheck;

class HealthCheckProjector implements \Ride\Application\Projector\Port\HealthCheckProjector
{

    public function __construct(
        private EntityManagerInterface $entityManager,
        private LoggerInterface $logger,
    )
    {
    }

    public function apply(HealthCheckOk $event): void
    {
        $this->logger->info('Healthcheck saving projection: ' . $event->getAggregateId()->toString());

        dump('Saving');

        $dbEntity = new HealthCheck();
        $dbEntity->setId(Uuid::fromString($event->getAggregateId()->toString()));

        dump($dbEntity);

        $this->entityManager->persist($dbEntity);
        $this->entityManager->flush();
        $this->logger->info('Healthcheck projection saved: ' . $dbEntity->getId()->toString(), $event->payload());
    }
}