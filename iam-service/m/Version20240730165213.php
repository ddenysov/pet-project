<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Types;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240730165213 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->createTable('outbox');

        $table->addColumn('id', Types::GUID)
            ->setNotnull(true);

        $table->addColumn('name', Types::STRING)
            ->setNotnull(true);

        $table->addColumn('event_id', Types::GUID)
            ->setNotnull(true);

        $table->addColumn('aggregate_id', Types::GUID)
            ->setNotnull(true);

        $table->addColumn('payload', Types::JSON)
            ->setNotnull(true);

        $table->addColumn('status', Types::STRING)
            ->setNotnull(true);

        $table->setPrimaryKey(['id']);
    }

    public function down(Schema $schema): void
    {

    }
}
