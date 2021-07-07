<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210707125134 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE signalement_image (id INT AUTO_INCREMENT NOT NULL, signalement_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, posted_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_4A502B9165C5E57E (signalement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE signalement_image ADD CONSTRAINT FK_4A502B9165C5E57E FOREIGN KEY (signalement_id) REFERENCES signalement (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE signalement_image');
    }
}
