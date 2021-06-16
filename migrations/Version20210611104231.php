<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210611104231 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE signalement ADD owner_id INT NOT NULL');
        $this->addSql('ALTER TABLE signalement ADD CONSTRAINT FK_F4B551147E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_F4B551147E3C61F9 ON signalement (owner_id)');
        $this->addSql('ALTER TABLE user DROP linkedin, DROP twitter, DROP facebook');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE signalement DROP FOREIGN KEY FK_F4B551147E3C61F9');
        $this->addSql('DROP INDEX IDX_F4B551147E3C61F9 ON signalement');
        $this->addSql('ALTER TABLE signalement DROP owner_id');
        $this->addSql('ALTER TABLE user ADD linkedin VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, ADD twitter VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, ADD facebook VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
