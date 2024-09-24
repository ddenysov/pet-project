<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240924123406 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ride ADD description TEXT NOT NULL');
        $this->addSql('ALTER TABLE ride ADD image_url VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE ride ADD start_lat DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE ride ADD start_lon DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE ride ADD end_lat DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE ride ADD end_lon DOUBLE PRECISION NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE "ride" DROP description');
        $this->addSql('ALTER TABLE "ride" DROP image_url');
        $this->addSql('ALTER TABLE "ride" DROP start_lat');
        $this->addSql('ALTER TABLE "ride" DROP start_lon');
        $this->addSql('ALTER TABLE "ride" DROP end_lat');
        $this->addSql('ALTER TABLE "ride" DROP end_lon');
    }
}
