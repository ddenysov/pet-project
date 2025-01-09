<?php

namespace Common\Domain\Event\Port;

use Common\Domain\ValueObject\Uuid;

interface Event
{
    /**
     * @return mixed
     */
    public function getId(): Uuid;

    /**
     * @return Uuid
     */
    public function getAggregateId(): Uuid;

    /**
     * @param Uuid $id
     * @return void
     */
    public function setAggregateId(Uuid $id): void;

    /**
     * @return array
     */
    public function toArray(): array;
}