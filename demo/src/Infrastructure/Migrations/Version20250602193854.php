<?php

declare(strict_types=1);

namespace Denysov\Demo\Infrastructure\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250602193854 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create event_store table for event-sourcing';
    }

    public function up(Schema $schema): void
    {
        // SQLite-friendly DDL (будет работать и в Postgres/MySQL — автодетект типов)
        $this->addSql(<<<'SQL'
        CREATE TABLE event_store (
            id            INTEGER PRIMARY KEY AUTOINCREMENT,
            aggregate_id  TEXT    NOT NULL,
            aggregate_type TEXT   NOT NULL,
            playhead      INTEGER NOT NULL,
            event_type    TEXT    NOT NULL,
            payload       TEXT    NOT NULL,  -- JSON-строка события
            metadata      TEXT,              -- JSON-строка метаданных
            recorded_at   DATETIME NOT NULL DEFAULT (datetime('now')),
            UNIQUE (aggregate_id, playhead)
        )
        SQL);

        $this->addSql('CREATE INDEX idx_event_store_aggregate_id ON event_store (aggregate_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE event_store');
    }
}
