<?php

namespace Iam\Infrastructure\Persistence\Doctrine\Entity;

use Doctrine\DBAL\Types\BigIntType;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;
use Iam\Infrastructure\Persistence\Doctrine\Repository\UserRepository;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`event_store`')]
class EventStore
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME)]
    private ?Uuid $id = null;

    #[ORM\Column(type: UuidType::NAME)]
    private ?Uuid $aggregateId = null;

    #[ORM\Column(type: Types::BIGINT)]
    private int $version;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private int $createdAt;

    #[ORM\Column(type: Types::JSON)]
    private int $payload;
}
