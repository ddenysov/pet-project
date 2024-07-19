<?php

namespace Common\Application\Handlers\Command;

use Common\Application\Handlers\Command\Attributes\Transaction;
use Common\Application\Handlers\Command\Port\TransactionManager;
use ReflectionException;
use ReflectionMethod;
use Throwable;

abstract class CommandHandler
{

    protected TransactionManager $transactionManager;

    /**
     * @param TransactionManager $transactionManager
     */
    public function __construct(TransactionManager $transactionManager)
    {
        $this->transactionManager = $transactionManager;
    }

    /**
     * @throws ReflectionException
     */
    public function __invoke(...$args): void
    {
        $methodName = 'handle';

        $reflectedMethod = new ReflectionMethod(static::class, $methodName);
        $hasTransaction = count($reflectedMethod->getAttributes(Transaction::class)) > 0;

        if ($hasTransaction) {
            $this->transactionManager->startTransaction();
        }
        try {
            $reflectedMethod->invokeArgs($this, $args);
        } catch (Throwable $exception) {
            if ($hasTransaction) {
                $this->transactionManager->rollback();
            }
        }
        if ($hasTransaction) {
            $this->transactionManager->commit();
        }
    }

    /**
     * @param TransactionManager $transactionManager
     * @return void
     */
    final public function setTransactionManager(TransactionManager $transactionManager): void
    {
        $this->transactionManager = $transactionManager;
    }
}