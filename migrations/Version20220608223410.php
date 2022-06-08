<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220608223410 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE club_skatepark (club_id INT NOT NULL, skatepark_id INT NOT NULL, INDEX IDX_44CA52161190A32 (club_id), INDEX IDX_44CA52189600404 (skatepark_id), PRIMARY KEY(club_id, skatepark_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE club_skatepark ADD CONSTRAINT FK_44CA52161190A32 FOREIGN KEY (club_id) REFERENCES club (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE club_skatepark ADD CONSTRAINT FK_44CA52189600404 FOREIGN KEY (skatepark_id) REFERENCES skatepark (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE club_skatepark');
    }
}
