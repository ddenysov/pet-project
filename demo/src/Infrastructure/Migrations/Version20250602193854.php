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
        return 'Create portable event_store table (aggregate events journal)';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->createTable('event_store');

        $table->addColumn('id',             'integer',  ['autoincrement' => true]);
        $table->addColumn('aggregate_id',   'string',   ['length' => 36]);   // UUID ⟶ 36
        $table->addColumn('aggregate_type', 'string',   ['length' => 64]);   // order | user | …
        $table->addColumn('playhead',       'integer');                      // version inside aggregate
        $table->addColumn('event_type',     'string',   ['length' => 255]);  // FQCN или короткий код
        $table->addColumn(
            'payload',
            'json',                        // → JSONB в Postgres, LONGTEXT в MySQL, TEXT в SQLite
            ['notnull' => true]
        );
        $table->addColumn('metadata', 'json', ['notnull' => false]);
        $table->addColumn(
            'recorded_at',
            'datetime_immutable',          // DATETIME, TIMESTAMP, или TEXT в SQLite
            ['default' => 'CURRENT_TIMESTAMP']
        );

        $table->setPrimaryKey(['id']);
        $table->addUniqueIndex(['aggregate_id', 'playhead']);
        $table->addIndex(['aggregate_id'], 'idx_event_store_aggregate_id');
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('event_store');
    }
}
