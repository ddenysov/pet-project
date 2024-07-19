<?php

namespace Iam\Infrastructure\Persistence\Doctrine\ReadModel;

use Common\Domain\ValueObject\Exception\InvalidUuidException;
use Common\Domain\ValueObject\Exception\String\InvalidStringLengthException;
use Iam\Domain\Entity\User;
use Iam\Domain\Repository\Port\ReadModel\UserRepository as UserRepositoryPort;
use Iam\Domain\ValueObject\UserEmail;
use Iam\Domain\ValueObject\UserId;
use Iam\Domain\ValueObject\UserPassword;
use Iam\Infrastructure\Persistence\Doctrine\Entity;
use Iam\Infrastructure\Persistence\Doctrine\Repository;
use Symfony\Component\Uid\Uuid;

class UserRepository extends Repository implements UserRepositoryPort
{
    /**
     * @param UserEmail $email
     * @return bool
     */
    public function isEmailTaken(UserEmail $email): bool
    {
        return (bool) $this->getEntityManager()->createQueryBuilder()
            ->select('COUNT(u.id)')
            ->from(Entity\User::class, 'u')
            ->where('u.email = :email')
            ->setParameter('email', $email->toString())
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * @throws InvalidStringLengthException
     * @throws InvalidUuidException
     */
    public function findOneByEmail(UserEmail $email): User
    {
        $dUser = $this->getEntityManager()->createQueryBuilder()
            ->select('u')
            ->from(Entity\User::class, 'u')
            ->where('u.email = :email')
            ->setParameter('email', $email->toString())
            ->getQuery()
            ->getSingleResult();

        return new User(
            id: new UserId($dUser->getId()->toString()),
            email: new UserEmail($dUser->getEmail()),
            password: new UserPassword($dUser->getPassword()),
        );
    }
}