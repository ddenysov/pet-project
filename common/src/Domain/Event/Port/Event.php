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
     * @param Uuid $id
     * @return void
     */
    public function setId(Uuid $id): void;

    /**
     * @return mixed
     */
    public function getAggregateId(): ?Uuid;

    /**
     * @param Uuid $id
     * @return void
     */
    public function setAggregateId(Uuid $id): void;

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return array
     */
    public function toArray(): array;

    /**
     * @return array
     */
    public function payload(): array;

    /**
     * @param array $payload
     * @return $this
     */
    public static function fromArray(array $payload): static;
}