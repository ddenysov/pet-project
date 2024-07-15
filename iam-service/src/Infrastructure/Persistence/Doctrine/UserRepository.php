<?php

namespace Iam\Infrastructure\Persistence\Doctrine;

use Common\Domain\Repository\Repository;
use Doctrine\ORM\EntityManagerInterface;
use Iam\Domain\Entity\User;
use Symfony\Component\Uid\Uuid;

class UserRepository extends Repository implements \Iam\Domain\Repository\Port\UserRepository
{
    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {

    }

    /**
     * @param User $user
     * @return void
     * @throws \Common\Domain\ValueObject\Exception\InvalidUuidException
     */
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