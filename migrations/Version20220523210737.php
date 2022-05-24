<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220523210737 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE club ADD cover_filename VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE session ADD cover_filename VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE shop ADD cover_filename VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE skatepark ADD cover_filename VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD cover_filename VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE club DROP cover_filename');
        $this->addSql('ALTER TABLE session DROP cover_filename');
        $this->addSql('ALTER TABLE shop DROP cover_filename');
        $this->addSql('ALTER TABLE skatepark DROP cover_filename');
        $this->addSql('ALTER TABLE user DROP cover_filename');
    }
}
