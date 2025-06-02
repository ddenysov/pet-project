<?php

declare(strict_types=1);

namespace Zinc\Core\DataStore\Bridge\PDO;

use Zinc\Core\DataStore\Bridge\PDO\Dialect\Dialect;

/**
 * Forward‑only SQL migration runner (very lightweight).
 */
final class SqlSchemaTool
{
    private const META = 'schema_migrations';

    public function __construct(private \PDO $pdo, private Dialect $dialect) {}

    public function up(string $dir): void
    {
        $this->initMeta();
        $done = $this->applied();

        $files = \glob(\rtrim($dir, '/') . "/*.sql");
        \sort($files);

        foreach ($files as $file) {
            $id = \basename($file);
            if (isset($done[$id])) {
                continue;
            }

            $sql = \file_get_contents($file);
            $ck  = SqlChecksum::hash($sql);

            $this->pdo->beginTransaction();
            try {
                $this->pdo->exec($sql);
                $stmt = $this->pdo->prepare('INSERT INTO ' . self::META . '(id,checksum) VALUES(:id,:ck)');
                $stmt->execute(['id' => $id,'ck' => $ck]);
                $this->pdo->commit();
                echo "✔ $id\n";
            } catch (\Throwable $e) {
                $this->pdo->rollBack();
                throw $e;
            }
        }
    }

    private function initMeta(): void
    {
        $ident = $this->dialect->quote(self::META);
        $ddl = "CREATE TABLE IF NOT EXISTS {$ident} (id VARCHAR(255) PRIMARY KEY, checksum VARCHAR(64) NOT NULL)";
        $this->pdo->exec($ddl);
    }

    /**
     * @return array<string,bool>
     */
    private function applied(): array
    {
        $rows = $this->pdo->query('SELECT id FROM ' . self::META)->fetchAll(\PDO::FETCH_COLUMN);
        return \array_fill_keys($rows, true);
    }
}
