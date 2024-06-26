<?php

namespace User\Infrastructure\Adapter\Persistence\Doctrine;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Uid\Uuid;
use User\Application\Outbox\OutboxStatus;
use User\Domain\Model\Event\DomainEvent;

class OutboxRepository implements \User\Application\Repository\OutboxRepository
{
    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {

    }

    /**
     * @throws \Exception
     */
    public function save(DomainEvent $event): void
    {
        $entity = new \User\Infrastructure\Adapter\Persistence\Doctrine\Entity\Outbox();
        $entity->setId($event->getEventId()->toUuid());
        $entity->setName($event->getName());
        $entity->setPayload($event->toArray());
        $entity->setStatus(OutboxStatus::STARTED);
        $entity->setCreateAt($event->getCreatedAt()->toDateTime());
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }
}