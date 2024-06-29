<?php

namespace User\Infrastructure\Persistence\Doctrine\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;
use User\Application\Outbox\OutboxStatus;
use User\Infrastructure\Persistence\Doctrine\Repository\UserRepository;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`outbox`')]
class Outbox
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME)]
    private ?Uuid $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: 'json')]
    private ?array $payload = [];

    #[ORM\Column()]
    private OutboxStatus $status;

    #[ORM\Column(type: 'datetime')]
    private DateTime $createdAt;

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function setId(?Uuid $id): void
    {
        $this->id = $id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getPayload(): ?array
    {
        return $this->payload;
    }

    public function setPayload(?array $payload): void
    {
        $this->payload = $payload;
    }

    public function getStatus(): OutboxStatus
    {
        return $this->status;
    }

    public function setStatus(OutboxStatus $status): void
    {
        $this->status = $status;
    }

    public function getCreateAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setCreateAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }
}
