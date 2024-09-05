<?php

namespace Ride\Infrastructure\Persistence\Doctrine\Entity;

use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Ride\Infrastructure\Persistence\Doctrine\Entity\Repository\StubRepository;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: StubRepository::class)]
#[ORM\Table(name: '`ride`')]
class Ride
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME)]
    private ?Uuid $id = null;

    #[ORM\Column(type: Types::STRING)]
    private string $name;

    #[ORM\Column(type: UuidType::NAME)]
    private ?Uuid $organizerId = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private DateTimeInterface $createdAt;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private DateTimeInterface $startDateTime;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private DateTimeInterface $endDateTime;

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

    public function getOrganizerId(): ?Uuid
    {
        return $this->organizerId;
    }

    public function setOrganizerId(?Uuid $organizerId): void
    {
        $this->organizerId = $organizerId;
    }

    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeInterface $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getStartDateTime(): DateTimeInterface
    {
        return $this->startDateTime;
    }

    public function setStartDateTime(DateTimeInterface $startDateTime): void
    {
        $this->startDateTime = $startDateTime;
    }

    public function getEndDateTime(): DateTimeInterface
    {
        return $this->endDateTime;
    }

    public function setEndDateTime(DateTimeInterface $endDateTime): void
    {
        $this->endDateTime = $endDateTime;
    }
}
