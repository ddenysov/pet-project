<?php
declare(strict_types=1);

namespace Zinc\Core\DataStore;

/**
 * Unit of Work tracks entity changes and flushes them in a single transaction.
 */
interface UnitOfWork
{
    public function registerNew(object $entity): void;
    public function registerDirty(object $entity): void;
    public function registerRemoved(object $entity): void;

    public function flush(): void;
}
