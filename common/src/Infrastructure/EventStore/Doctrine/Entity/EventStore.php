<?php

namespace Common\Infrastructure\EventStore\Doctrine\Entity;

use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[ORM\Table(name: '`event_store`')]
class EventStore
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME)]
    private ?Uuid $id = null;

    #[ORM\Column(type: UuidType::NAME)]
    private ?Uuid $aggregateId = null;

    #[ORM\Column(type: 'json')]
    private array $payload;

    #[ORM\Column(type: 'datetime')]
    private DateTimeInterface $created_at;
}
