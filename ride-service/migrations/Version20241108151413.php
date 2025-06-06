<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241108151413 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE "track" (id UUID NOT NULL, name VARCHAR(255) NOT NULL, owner_id UUID NOT NULL, length DOUBLE PRECISION DEFAULT \'0\' NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN "track".id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN "track".owner_id IS \'(DC2Type:uuid)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE "track"');
    }
}
