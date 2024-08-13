<?php

namespace Iam\Infrastructure\Persistence\Doctrine\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Iam\Application\Handlers\Query\Projection\UserCredentials;
use Iam\Application\Handlers\Query\Repository\Port\UserCredentialsRepository as UserCredentialsRepositoryPort;
use Iam\Infrastructure\Persistence\Doctrine\Entity\User;

class UserCredentialsRepository extends ServiceEntityRepository implements UserCredentialsRepositoryPort
{
    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function findByEmail(string $email): ?UserCredentials
    {
        $result = $this->createQueryBuilder('p')
            ->where('p.email = :email')
            ->setParameter('email', $email)
            ->getQuery()
            ->execute();

        // @TODO Add uniq email constraint
        if (!count($result)) {
            return null;
        }

        return new UserCredentials(
            id: $result[0]->getId(),
            email: $result[0]->getEmail(),
            password: $result[0]->getPassword(),
        );
    }
}
