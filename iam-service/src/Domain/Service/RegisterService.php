<?php

namespace Iam\Domain\Service;

use Common\Domain\Event\EventCollection;
use Common\Domain\ValueObject\Exception\InvalidUuidException;
use Common\Domain\ValueObject\Exception\String\InvalidStringLengthException;
use Iam\Domain\Entity\User;
use Iam\Domain\Event\UserRegistered;
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
        private readonly ByEmailCriteria $byEmailCriteria,
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
        $existingUser = $this->userRepository->addCriteria()
        $events = new EventCollection();
        $user = new User(
            id: UserId::create(),
            email: new UserEmail($email),
            password: new UserPassword($password)
        );

        $this->userRepository->save($user);
        $events->add(new UserRegistered($user));

        return $events;
    }
}