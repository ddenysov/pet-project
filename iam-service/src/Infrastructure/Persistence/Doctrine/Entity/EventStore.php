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
    private string $name;

    #[ORM\Column(type: UuidType::NAME)]
    private ?Uuid $aggregateId = null;

    #[ORM\Column(type: Types::BIGINT)]
    private int $version;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private \DateTime $createdAt;

    #[ORM\Column(type: Types::JSON)]
    private array $payload;

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function setId(?Uuid $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
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

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getPayload(): array
    {
        return $this->payload;
    }

    public function setPayload(array $payload): void
    {
        $this->payload = $payload;
    }
}
