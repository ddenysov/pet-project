<?php

namespace Iam\Infrastructure\Persistence\Doctrine;

use Doctrine\ORM\EntityManagerInterface;

abstract class Repository
{
    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    )
    {
    }

    public function getEntityManager(): EntityManagerInterface
    {
        return $this->entityManager;
    }
}