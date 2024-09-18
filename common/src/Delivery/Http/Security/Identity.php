<?php

namespace Common\Delivery\Http\Security;

use Common\Domain\ValueObject\Uuid;

class Identity
{
    /**
     * @var Uuid|null
     */
    public ?Uuid $id = null;

    /**
     * @var array
     */
    public array $roles = [];

    /**
     * @return Uuid|null
     */
    public function getId(): ?Uuid
    {
        return $this->id;
    }

    /**
     * @param Uuid $id
     * @return void
     */
    public function setId(Uuid $id): void
    {
        $this->id = $id;
    }

    /**
     * @return array
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @param array $roles
     * @return void
     */
    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }
}