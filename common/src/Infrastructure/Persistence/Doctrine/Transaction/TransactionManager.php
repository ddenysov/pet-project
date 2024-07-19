<?php

namespace Common\Infrastructure\Persistence\Doctrine\Transaction;

use Common\Application\Handlers\Command\Port\TransactionManager as TransactionManagerPort;
use Doctrine\ORM\EntityManagerInterface;

class TransactionManager implements TransactionManagerPort
{


    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    )
    {
    }

    public function startTransaction(): void
    {
        $this->entityManager->beginTransaction();
    }

    public function commit(): void
    {
        $this->entityManager->commit();
    }

    public function rollback(): void
    {
        $this->entityManager->rollback();
    }
}