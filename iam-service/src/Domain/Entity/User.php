<?php

namespace Iam\Domain\Entity;

use Common\Domain\Entity\Aggregate;
use Common\Domain\ValueObject\Exception\InvalidUuidException;
use Common\Domain\ValueObject\Uuid;
use Iam\Domain\Event\UserPasswordResetRequested;
use Iam\Domain\Event\UserRegistered;
use Iam\Domain\ValueObject\UserEmail;
use Iam\Domain\ValueObject\UserId;
use Iam\Domain\ValueObject\UserPassword;

final class User extends Aggregate
{
    public function __construct(
        Uuid $id,
        private UserEmail $email,
        private UserPassword $password
    )
    {
        parent::__construct($id);
    }

    /**
     * @return UserId
     * @throws InvalidUuidException
     */
    public function getId(): UserId
    {
        return UserId::fromUuid($this->id);
    }

    /**
     * @return UserPassword
     */
    public function getPassword(): UserPassword
    {
        return $this->password;
    }

    /**
     * @param UserPassword $password
     * @return void
     */
    public function setPassword(UserPassword $password): void
    {
        $this->password = $password;
    }

    public function getEmail(): UserEmail
    {
        return $this->email;
    }

    /**
     * @param UserEmail $email
     * @return void
     */
    public function setEmail(UserEmail $email): void
    {
        $this->email = $email;
    }

    /**
     * @throws InvalidUuidException
     */
    public static function register(
        UserEmail $email,
        UserPassword $password
    ): User {
        $user = new User(
            id: UserId::create(),
            email: $email,
            password: $password
        );

        $user->recordThat(new UserRegistered($user));

        return $user;
    }

    /**
     * @return void
     */
    public function requestResetPassword(): void {
        $this->recordThat(new UserPasswordResetRequested($this));
    }

    /**
     * @param string $password
     * @return bool
     */
    public function checkPassword(string $password): bool
    {
        return $this->password->check($password);
    }
}