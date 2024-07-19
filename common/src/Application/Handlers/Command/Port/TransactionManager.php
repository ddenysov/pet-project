<?php

namespace Common\Application\Handlers\Command\Port;

interface TransactionManager
{
    /**
     * @return void
     */
    public function startTransaction(): void;

    /**
     * @return void
     */
    public function commit(): void;

    /**
     * @return void
     */
    public function rollback(): void;
}