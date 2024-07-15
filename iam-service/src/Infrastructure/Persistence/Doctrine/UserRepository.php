<?php

namespace Iam\Infrastructure\Persistence\Doctrine;

use Common\Domain\Repository\Repository;
use Doctrine\ORM\EntityManagerInterface;
use Iam\Domain\Entity\User;
use Iam\Domain\Repository\Port\UserRepository as UserRepositoryPort;
use Symfony\Component\Uid\Uuid;

class UserRepository extends Repository implements UserRepositoryPort
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
     */
    public function save(User $user): void
    {
        $dUser = new Entity\User();
        $dUser->setId(Uuid::fromString($user->getId()->toString()));
        $dUser->setEmail($user->getEmail()->toString());
        $dUser->setPassword($user->getPassword()->toString());
        $this->entityManager->persist($dUser);
        $this->entityManager->flush();
    }
}