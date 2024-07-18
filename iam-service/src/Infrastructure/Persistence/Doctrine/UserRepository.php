<?php

namespace Iam\Infrastructure\Persistence\Doctrine;

use Common\Domain\ValueObject\Exception\InvalidUuidException;
use Common\Domain\ValueObject\Exception\String\InvalidStringLengthException;
use Doctrine\ORM\Query;
use Iam\Domain\Entity\User;
use Iam\Domain\Repository\Port\UserRepository as UserRepositoryPort;
use Iam\Domain\ValueObject\UserEmail;
use Iam\Domain\ValueObject\UserId;
use Iam\Domain\ValueObject\UserPassword;
use Symfony\Component\Uid\Uuid;

class UserRepository extends Repository implements UserRepositoryPort
{
    /**
     * @throws InvalidStringLengthException
     * @throws InvalidUuidException
     */
    public function findOneByEmail(UserEmail $email): ?User
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('u')
            ->from('\Iam\Infrastructure\Persistence\Doctrine\Entity\User', 'u')
            ->where('u.email = :email')
            ->setParameter('email', $email->toString());


        $query = $qb->getQuery();
        /**
         * @var \Iam\Infrastructure\Persistence\Doctrine\Entity\User $result
         */
        $result = $qb->getQuery()->getResult();

        if (!isset($result[0])) {
            return null;
        }

        return new User(
            id: new UserId($result[0]->getId()->toString()),
            email: new UserEmail($result[0]->getEmail()),
            password: new UserPassword($result[0]->getPassword()),
        );
    }



    /**
     * @param User $user
     * @return void
     * @throws InvalidUuidException
     */
    public function save(User $user): void
    {
        $dUser = new Entity\User();
        $dUser->setId(Uuid::fromString($user->getId()->toString()));
        $dUser->setEmail($user->getEmail()->toString());
        $dUser->setPassword($user->getPassword()->toString());
        $this->getEntityManager()->persist($dUser);
        $this->getEntityManager()->flush();
    }
}