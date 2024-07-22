<?php

namespace Common\Domain\Event\Port;

use Common\Domain\ValueObject\Uuid;

interface Event
{
    /**
     * @return mixed
     */
    public function getId();

    /**
     * @param Uuid $id
     * @return mixed
     */
    public function setId(Uuid $id);

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return array
     */
    public function toArray(): array;
}