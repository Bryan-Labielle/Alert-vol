<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210617071109 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annonce ADD slug VARCHAR(255) DEFAULT NULL, CHANGE location location INT DEFAULT NULL');
        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C19777D11E');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C19777D11E FOREIGN KEY (category_id_id) REFERENCES category (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annonce DROP slug, CHANGE location location INT NOT NULL');
        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C19777D11E');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C19777D11E FOREIGN KEY (category_id_id) REFERENCES category (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}
