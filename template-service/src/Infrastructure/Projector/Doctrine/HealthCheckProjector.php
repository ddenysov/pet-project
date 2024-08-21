<?php

namespace Template\Infrastructure\Projector\Doctrine;

use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Uid\Uuid;
use Template\Domain\Event\HealthCheckOk;
use Template\Infrastructure\Persistence\Doctrine\Entity\HealthCheck;

class HealthCheckProjector implements \Template\Application\Projector\Port\HealthCheckProjector
{

    public function __construct(
        private EntityManagerInterface $entityManager,
        private LoggerInterface $logger,
    )
    {
    }

    public function apply(HealthCheckOk $event): void
    {
        $dbEntity = new HealthCheck();
        $dbEntity->setId(Uuid::fromString($event->getAggregateId()->toString()));

        $this->entityManager->persist($dbEntity);
        $this->entityManager->flush();
        $this->logger->info('Healthcheck projection saved: ' . $dbEntity->getId()->toString(), $event->payload());
    }
}