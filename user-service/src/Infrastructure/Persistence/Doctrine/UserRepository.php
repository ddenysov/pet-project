<?php

namespace User\Infrastructure\Persistence\Doctrine;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Uid\Uuid;
use User\Domain\Model\Entity\User;
use User\Domain\Model\ValueObject\UserId;
use User\Infrastructure\Persistence\Doctrine\Entity\User as UserEntity;

class UserRepository implements \User\Application\Ports\Output\Repository\UserRepository
{
    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {

    }
    public function save(User $user): void
    {
        $entity = new UserEntity();
        $entity->setId(Uuid::fromString($user->getId()->toString()));
        $entity->setName($user->getName()->toString());
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

    public function find(UserId $id): ?User
    {
        // TODO: Implement find() method.
    }
}