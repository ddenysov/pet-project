<?php

namespace Common\Application\Handlers\Command;

use Common\Application\Container\Port\ServiceContainer;
use Common\Application\Handlers\Command\Attributes\Transaction;
use Common\Application\Handlers\Command\Port\TransactionManager;
use Common\Domain\Entity\Port\Aggregate;
use ReflectionException;
use ReflectionMethod;
use Throwable;

abstract class CommandHandler
{

    protected TransactionManager $transactionManager;

    public function __construct(
        private ServiceContainer $container,
    ) {
    }

    /**
     * @param ...$args
     * @return void
     * @throws ReflectionException
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws Throwable
     */
    public function __invoke(...$args): void
    {
        $methodName = 'handle';

        $reflectedMethod = new ReflectionMethod(static::class, $methodName);
        $hasTransaction = count($reflectedMethod->getAttributes(Transaction::class)) > 0;

        if ($hasTransaction) {
            $this->getTransactionManager()->startTransaction();
        }
        try {
            $reflectedMethod->invokeArgs($this, $args);
        } catch (Throwable $exception) {
            if ($hasTransaction) {
                $this->getTransactionManager()->rollback();
            }
            throw $exception;
        }

        if ($hasTransaction) {
            $this->getTransactionManager()->commit();
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

    /**
     * @return TransactionManager
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    final protected function getTransactionManager(): TransactionManager
    {
        return $this->getContainer()->get(TransactionManager::class);
    }

    /**
     * @return ServiceContainer
     */
    public function getContainer(): ServiceContainer
    {
        return $this->container;
    }

    public function publishAggregateEvents(Aggregate $aggregate)
    {
        $events = $aggregate->releaseEvents();
    }
}