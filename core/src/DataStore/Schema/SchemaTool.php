<?php

declare(strict_types=1);

namespace Zinc\Core\DataStore\Schema;

/**
 * Minimal schema‑management contract (migrations, dumps, status).
 */
interface SchemaTool
{
    public function status(): SchemaStatus;

    public function up(string $migrationDir): void;

    public function dump(string $targetFile): void;
}
