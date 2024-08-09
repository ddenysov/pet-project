<?php

namespace Iam\Infrastructure\Persistence\Doctrine\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Iam\Infrastructure\Persistence\Doctrine\Entity\Repository\StubRepository;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: StubRepository::class)]
#[ORM\Table(name: '`event_store`')]
class EventStore
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME)]
    private ?Uuid $id = null;

    #[ORM\Column(type: Types::STRING)]
    private int $name;

    #[ORM\Column(type: UuidType::NAME)]
    private ?Uuid $aggregateId = null;

    #[ORM\Column(type: Types::BIGINT)]
    private int $version;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private int $createdAt;

    #[ORM\Column(type: Types::JSON)]
    private int $payload;

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function setId(?Uuid $id): void
    {
        $this->id = $id;
    }

    public function getName(): int
    {
        return $this->name;
    }

    public function setName(int $name): void
    {
        $this->name = $name;
    }

    public function getAggregateId(): ?Uuid
    {
        return $this->aggregateId;
    }

    public function setAggregateId(?Uuid $aggregateId): void
    {
        $this->aggregateId = $aggregateId;
    }

    public function getVersion(): int
    {
        return $this->version;
    }

    public function setVersion(int $version): void
    {
        $this->version = $version;
    }

    public function getCreatedAt(): int
    {
        return $this->createdAt;
    }

    public function setCreatedAt(int $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getPayload(): int
    {
        return $this->payload;
    }

    public function setPayload(int $payload): void
    {
        $this->payload = $payload;
    }
}
