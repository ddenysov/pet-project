<?php

declare(strict_types=1);

namespace Denysov\Demo\Infrastructure\Migrations\Doctrine;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250602210259 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create portable outbox table (transactional outbox pattern)';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->createTable('outbox');

        $table->addColumn('id', 'guid');                         // <-- был integer
        $table->addColumn('aggregate_id',   'guid',   ['length' => 36]);
        $table->addColumn('aggregate_type', 'string',   ['length' => 64]);
        $table->addColumn('message_type',   'string',   ['length' => 255]);
        $table->addColumn('payload',        'json',     ['notnull' => true]);
        $table->addColumn('metadata',       'json',     ['notnull' => false]);
        $table->addColumn(
            'created_at',
            'datetime_immutable',
            ['default' => 'CURRENT_TIMESTAMP']
        );
        $table->addColumn('published_at', 'datetime_immutable', ['notnull' => false]);
        $table->addColumn('attempts',      'integer',   ['default' => 0]);
        $table->addColumn('locked_until',  'datetime_immutable', ['notnull' => false]);

        $table->setPrimaryKey(['id']);
        $table->addIndex(['published_at', 'attempts'], 'idx_outbox_dispatch');
        $table->addIndex(['locked_until'], 'idx_outbox_lock');
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('outbox');
    }
}
