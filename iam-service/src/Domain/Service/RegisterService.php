<?php

namespace Iam\Domain\Service;

use Common\Domain\Event\EventCollection;
use Common\Domain\ValueObject\Exception\InvalidUuidException;
use Common\Domain\ValueObject\Exception\String\InvalidStringLengthException;
use Iam\Domain\Entity\User;
use Iam\Domain\Event\UserRegistered;
use Iam\Domain\Event\UserRegisteredWithExistingEmail;
use Iam\Domain\Repository\Criteria\ByUserEmailCriteria;
use Iam\Domain\Repository\Port\Criteria\ByEmailCriteria;
use Iam\Domain\Repository\Port\UserRepository;
use Iam\Domain\ValueObject\UserEmail;
use Iam\Domain\ValueObject\UserId;
use Iam\Domain\ValueObject\UserPassword;

class RegisterService
{
    /**
     * @param UserRepository $userRepository
     * @param ByEmailCriteria $byEmailCriteria
     */
    public function __construct(
        private readonly UserRepository $userRepository,
    ) {

    }

    /**
     * @param string $email
     * @param string $password
     * @return EventCollection
     * @throws InvalidUuidException
     * @throws InvalidStringLengthException
     */
    public function execute(string $email, string $password): EventCollection
    {
        $events = new EventCollection();
        $existingUser = $this->userRepository->findOneByEmail(new UserEmail($email));


        if (!$existingUser) {
            $user = new User(
                id: UserId::create(),
                email: new UserEmail($email),
                password: new UserPassword($password)
            );

            $this->userRepository->save($user);
            $events->add(new UserRegistered($user));
        } else {
            $events->add(new UserRegisteredWithExistingEmail($existingUser));
        }


        return $events;
    }
}