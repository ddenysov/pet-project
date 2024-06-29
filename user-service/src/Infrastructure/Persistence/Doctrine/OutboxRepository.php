<?php

namespace User\Infrastructure\Persistence\Doctrine;

use Doctrine\ORM\EntityManagerInterface;
use User\Application\Outbox\OutboxStatus;
use User\Domain\Model\Event\DomainEvent;
use User\Infrastructure\Persistence\Doctrine\Entity\Outbox;

class OutboxRepository implements \User\Application\Outbox\OutboxRepository
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
    public function save(\User\Application\Outbox\Outbox $outbox): void
    {
        $entity = new \User\Infrastructure\Persistence\Doctrine\Entity\Outbox();
        $entity->setId($outbox->id);
        $entity->setName($outbox->name);
        $entity->setPayload($outbox->payload);
        $entity->setStatus(OutboxStatus::STARTED);
        $entity->setCreateAt($outbox->createdAt);
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

    public function all()
    {
        $collection = $this->entityManager->createQueryBuilder()
            ->select('o')
            ->from('User\Infrastructure\Persistence\Doctrine\Entity\Outbox', 'o')
            ->getQuery()
            ->getResult();

        return [];
    }
}