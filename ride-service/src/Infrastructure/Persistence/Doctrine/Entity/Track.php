<?php

namespace Ride\Infrastructure\Persistence\Doctrine\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Ride\Infrastructure\Persistence\Doctrine\Entity\Repository\StubRepository;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: StubRepository::class)]
#[ORM\Table(name: '`track`')]
class Track
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME)]
    private ?Uuid $id = null;

    #[ORM\Column(type: Types::STRING)]
    private string $name;
}
