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

    #[ORM\Column(type: Types::TEXT)]
    private string $description;

    #[ORM\Column(type: Types::STRING)]
    private string $imageUrl;

    #[ORM\Column(type: Types::FLOAT)]
    private float $startLat;

    #[ORM\Column(type: Types::FLOAT)]
    private float $startLon;

    #[ORM\Column(type: Types::FLOAT)]
    private float $endLat;

    #[ORM\Column(type: Types::FLOAT)]
    private float $endLon;

    #[ORM\Column(type: UuidType::NAME)]
    private ?Uuid $organizerId = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private DateTimeInterface $createdAt;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private DateTimeInterface $startDateTime;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private DateTimeInterface $endDateTime;

    #[ORM\Column(type: Types::JSON, options: ['default'=> '[]'])]
    private array $riders = [];

    /**
     * @var array
     */
    #[ORM\Column(type: Types::JSON, options: ['default'=> '[]'])]
    private array $pendingRiders = [];

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

    public function getRiders(): array
    {
        return $this->riders;
    }

    public function setRiders(array $riders): void
    {
        $this->riders = $riders;
    }

    /**
     * @param string $riderId
     * @return void
     */
    public function addRider(string $riderId)
    {
        $this->riders[] = $riderId;
    }

    public function getPendingRiders(): array
    {
        return $this->pendingRiders;
    }

    public function setPendingRiders(array $pendingRiders): void
    {
        $this->pendingRiders = $pendingRiders;
    }

    public function addPendingRider(string $riderId)
    {
        $this->pendingRiders[] = $riderId;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getImageUrl(): string
    {
        return $this->imageUrl;
    }

    public function setImageUrl(string $imageUrl): void
    {
        $this->imageUrl = $imageUrl;
    }

    public function getStartLat(): float
    {
        return $this->startLat;
    }

    public function setStartLat(float $startLat): void
    {
        $this->startLat = $startLat;
    }

    public function getStartLon(): float
    {
        return $this->startLon;
    }

    public function setStartLon(float $startLon): void
    {
        $this->startLon = $startLon;
    }

    public function getEndLat(): float
    {
        return $this->endLat;
    }

    public function setEndLat(float $endLat): void
    {
        $this->endLat = $endLat;
    }

    public function getEndLon(): float
    {
        return $this->endLon;
    }

    public function setEndLon(float $endLon): void
    {
        $this->endLon = $endLon;
    }
}
