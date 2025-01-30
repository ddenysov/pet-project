<?php

namespace Common\Application\Repository;

interface HasTransactions
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