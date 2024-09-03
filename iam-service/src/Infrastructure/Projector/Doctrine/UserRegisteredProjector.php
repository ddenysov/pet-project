<?php

namespace Iam\Infrastructure\Projector\Doctrine;

use Doctrine\ORM\EntityManagerInterface;
use Iam\Application\Projector\Port\UserProjector as UserProjectorPort;
use Iam\Application\Projector\Port\UserRegisteredProjector as UserRegisteredProjectorPort;
use Iam\Domain\Event\UserEvent;
use Iam\Domain\Event\UserRegistered;
use Iam\Infrastructure\Persistence\Doctrine\Entity\User;
use Psr\Log\LoggerInterface;
use Symfony\Component\Uid\Uuid;

class UserRegisteredProjector implements UserRegisteredProjectorPort
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

    public function apply(UserRegistered $event): void
    {
        $this->logger->info('User creating projection: ' . $event->getAggregateId()->toString());

        $dbEntity = new User();
        $dbEntity->setId(Uuid::fromString($event->getAggregateId()->toString()));
        $dbEntity->setEmail($event->email->toString());
        $dbEntity->setPassword($event->password->toString());

        $this->entityManager->persist($dbEntity);
        $this->entityManager->flush();
        $this->logger->info('User projection created: ' . $dbEntity->getId()->toString(), $event->payload());
    }
}