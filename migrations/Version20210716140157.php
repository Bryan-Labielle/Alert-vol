<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210716140157 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE details (id INT AUTO_INCREMENT NOT NULL, annonce_id INT NOT NULL, detail VARCHAR(255) DEFAULT NULL, INDEX IDX_72260B8A8805AB2F (annonce_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE details ADD CONSTRAINT FK_72260B8A8805AB2F FOREIGN KEY (annonce_id) REFERENCES annonce (id)');
        $this->addSql('DROP TABLE bookmark');
        $this->addSql('ALTER TABLE annonce ADD city VARCHAR(100) DEFAULT NULL, DROP details, CHANGE location zip INT DEFAULT NULL');
        $this->addSql('ALTER TABLE annonce_image DROP is_signaled, CHANGE name name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C19777D11E');
        $this->addSql('DROP INDEX IDX_64C19C19777D11E ON category');
        $this->addSql('ALTER TABLE category CHANGE category_id_id category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C112469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_64C19C112469DE2 ON category (category_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bookmark (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE details');
        $this->addSql('ALTER TABLE annonce ADD details JSON DEFAULT NULL, DROP city, CHANGE zip location INT DEFAULT NULL');
        $this->addSql('ALTER TABLE annonce_image ADD is_signaled TINYINT(1) DEFAULT NULL, CHANGE name name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C112469DE2');
        $this->addSql('DROP INDEX IDX_64C19C112469DE2 ON category');
        $this->addSql('ALTER TABLE category CHANGE category_id category_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C19777D11E FOREIGN KEY (category_id_id) REFERENCES category (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_64C19C19777D11E ON category (category_id_id)');
    }
}
