<?php

namespace Tests\Application\Event\Stub;

use Common\Domain\Event\Port\Event;
use Common\Domain\ValueObject\Exception\InvalidUuidException;
use Common\Domain\ValueObject\PasswordValue;
use Common\Domain\ValueObject\StringValue;

class StubEvent extends \Common\Domain\Event\Event implements Event
{
    /**
     * @param StringValue $name
     * @throws InvalidUuidException
     */
    public function __construct(
        private StringValue $userName,
        private PasswordValue $password
    ) {
        parent::__construct();
    }

    public function getUserName(): StringValue
    {
        return $this->userName;
    }

    public function setUserName(StringValue $userName): void
    {
        $this->userName = $userName;
    }

    public function getPassword(): PasswordValue
    {
        return $this->password;
    }

    public function setPassword(PasswordValue $password): void
    {
        $this->password = $password;
    }
}