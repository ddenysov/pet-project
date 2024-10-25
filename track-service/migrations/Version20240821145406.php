<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240821145406 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE "event_store" (id UUID NOT NULL, name VARCHAR(255) NOT NULL, aggregate_id UUID NOT NULL, version BIGINT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, payload JSON NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN "event_store".id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN "event_store".aggregate_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE "health_check" (id UUID NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN "health_check".id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE "outbox" (id UUID NOT NULL, name VARCHAR(255) NOT NULL, event_id UUID NOT NULL, status VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, payload JSON NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN "outbox".id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN "outbox".event_id IS \'(DC2Type:uuid)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE "event_store"');
        $this->addSql('DROP TABLE "health_check"');
        $this->addSql('DROP TABLE "outbox"');
    }
}
