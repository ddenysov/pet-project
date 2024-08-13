<?php

namespace Iam\Infrastructure\Projector\Doctrine;

use Doctrine\ORM\EntityManagerInterface;
use Iam\Application\Projector\Port\UserProjector as UserProjectorPort;
use Iam\Domain\Event\UserEvent;
use Iam\Domain\Event\UserRegistered;
use Iam\Infrastructure\Persistence\Doctrine\Entity\User;
use Psr\Log\LoggerInterface;
use Symfony\Component\Uid\Uuid;

class UserProjector implements UserProjectorPort
{

    public function __construct(
        private EntityManagerInterface $entityManager,
        private LoggerInterface $logger,
    )
    {
    }

    public function apply(UserEvent $event): void
    {
        if ($event->isA(UserRegistered::class)) {
            $user = new User();
            $user->setId(Uuid::fromString($event->getAggregateId()->toString()));
        } else {
            $user = $this->entityManager->find(User::class, $event->getAggregateId()->toString());
        }

        foreach ($event->payload() as $key => $value) {
            $method = 'set' . ucfirst($key);
            $user->$method($value);
        }

        $this->entityManager->persist($user);
        $this->entityManager->flush();
        $this->logger->info('User projection saved: ' . $user->getId()->toString(), $event->payload());
    }
}