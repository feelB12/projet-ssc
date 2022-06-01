<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220601125123 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE club ADD longitude DOUBLE PRECISION DEFAULT NULL, ADD latitude DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE session ADD longitude_start_at DOUBLE PRECISION DEFAULT NULL, ADD latitude_start_at DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE shop ADD longitude DOUBLE PRECISION DEFAULT NULL, ADD latitude DOUBLE PRECISION DEFAULT NULL, ADD club VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE skatepark ADD longitude DOUBLE PRECISION DEFAULT NULL, ADD latitude DOUBLE PRECISION DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE club DROP longitude, DROP latitude');
        $this->addSql('ALTER TABLE session DROP longitude_start_at, DROP latitude_start_at');
        $this->addSql('ALTER TABLE shop DROP longitude, DROP latitude, DROP club');
        $this->addSql('ALTER TABLE skatepark DROP longitude, DROP latitude');
    }
}
