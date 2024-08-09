<?php

namespace Iam\Infrastructure\Persistence\Doctrine\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;
use Iam\Infrastructure\Persistence\Doctrine\Repository\UserRepository;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`outbox`')]
class Outbox
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME)]
    private ?Uuid $id = null;

    #[ORM\Column(type: UuidType::NAME)]
    private ?Uuid $eventId = null;

    #[ORM\Column(type: Types::STRING)]
    private int $status;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private int $createdAt;

    #[ORM\Column(type: Types::JSON)]
    private int $payload;
}
