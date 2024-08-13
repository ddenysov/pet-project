<?php

namespace Iam\Domain\Entity;

use Common\Domain\Entity\Aggregate;
use Common\Domain\ValueObject\Exception\InvalidUuidException;
use Iam\Domain\Event\UserPasswordResetRequested;
use Iam\Domain\Event\UserRegistered;
use Iam\Domain\ValueObject\UserEmail;
use Iam\Domain\ValueObject\UserId;
use Iam\Domain\ValueObject\UserPassword;

final class User extends Aggregate
{
    /**
     * @var UserPassword
     */
    private UserPassword $password;

    /**
     * @var UserEmail
     */
    private UserEmail $email;

    protected static array $subscribers = [
        UserRegistered::class => [
            'onUserRegistered',
        ],
    ];

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
        $user = self::create();
        $user->recordThat(new UserRegistered(
            UserId::create(),
            $email,
            $password,
        ));

        return $user;
    }

    /**
     * @return void
     */
    public function requestResetPassword(): void {
        $this->recordThat(new UserPasswordResetRequested());
    }

    /**
     * @param string $password
     * @return bool
     */
    public function checkPassword(string $password): bool
    {
        return $this->password->check($password);
    }

    protected function onUserRegistered(UserRegistered $event)
    {
        $this->setId($event->aggregateId);
        $this->setEmail($event->email);
        $this->setPassword($event->password);
    }
}