<?php

declare(strict_types=1);

namespace Denysov\Demo\Infrastructure\Migrations\Doctrine;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250605161527 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Creates read_model_users table with id (UUID) and email (string)';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->createTable('read_model_users');

        $table->addColumn('id', 'guid'); // UUID
        $table->addColumn('email', 'string', ['length' => 255]);

        $table->setPrimaryKey(['id']);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('read_model_users');
    }
}
