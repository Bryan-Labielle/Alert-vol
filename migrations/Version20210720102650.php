<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210720102650 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE annonce (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, owner_id INT DEFAULT NULL, title VARCHAR(45) NOT NULL, description LONGTEXT DEFAULT NULL, published_at DATETIME NOT NULL, nb_renew INT DEFAULT NULL, end_published_at DATETIME NOT NULL, reference VARCHAR(255) NOT NULL, status INT NOT NULL, zip INT DEFAULT NULL, stolen_at DATETIME NOT NULL, slug VARCHAR(255) NOT NULL, city VARCHAR(100) DEFAULT NULL, INDEX IDX_F65593E512469DE2 (category_id), INDEX IDX_F65593E57E3C61F9 (owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE annonce_image (id INT AUTO_INCREMENT NOT NULL, annonce_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, posted_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_D2B0CFC08805AB2F (annonce_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, name VARCHAR(85) NOT NULL, INDEX IDX_64C19C112469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE details (id INT AUTO_INCREMENT NOT NULL, annonce_id INT NOT NULL, detail VARCHAR(255) DEFAULT NULL, INDEX IDX_72260B8A8805AB2F (annonce_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, sender_id INT DEFAULT NULL, recipient_id INT DEFAULT NULL, signalement_id INT DEFAULT NULL, content LONGTEXT NOT NULL, sent_at DATETIME NOT NULL, INDEX IDX_B6BD307FF624B39D (sender_id), INDEX IDX_B6BD307FE92F8F78 (recipient_id), INDEX IDX_B6BD307F65C5E57E (signalement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE signalement (id INT AUTO_INCREMENT NOT NULL, annonce_id INT DEFAULT NULL, owner_id INT DEFAULT NULL, details JSON DEFAULT NULL, send_at DATETIME NOT NULL, seen_on DATETIME NOT NULL, latitude DOUBLE PRECISION NOT NULL, longitude DOUBLE PRECISION NOT NULL, image VARCHAR(255) DEFAULT NULL, INDEX IDX_F4B551148805AB2F (annonce_id), INDEX IDX_F4B551147E3C61F9 (owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE signalement_image (id INT AUTO_INCREMENT NOT NULL, signalement_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, posted_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_4A502B9165C5E57E (signalement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, address VARCHAR(255) DEFAULT NULL, zip INT DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, avatar VARCHAR(255) DEFAULT NULL, role INT NOT NULL, is_verified TINYINT(1) NOT NULL, pseudo VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E512469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E57E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE annonce_image ADD CONSTRAINT FK_D2B0CFC08805AB2F FOREIGN KEY (annonce_id) REFERENCES annonce (id)');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C112469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE details ADD CONSTRAINT FK_72260B8A8805AB2F FOREIGN KEY (annonce_id) REFERENCES annonce (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FF624B39D FOREIGN KEY (sender_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FE92F8F78 FOREIGN KEY (recipient_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F65C5E57E FOREIGN KEY (signalement_id) REFERENCES signalement (id)');
        $this->addSql('ALTER TABLE signalement ADD CONSTRAINT FK_F4B551148805AB2F FOREIGN KEY (annonce_id) REFERENCES annonce (id)');
        $this->addSql('ALTER TABLE signalement ADD CONSTRAINT FK_F4B551147E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE signalement_image ADD CONSTRAINT FK_4A502B9165C5E57E FOREIGN KEY (signalement_id) REFERENCES signalement (id)');
        $this->addSql('ALTER TABLE user_annonce ADD CONSTRAINT FK_AE588DEFA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_annonce ADD CONSTRAINT FK_AE588DEF8805AB2F FOREIGN KEY (annonce_id) REFERENCES annonce (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annonce_image DROP FOREIGN KEY FK_D2B0CFC08805AB2F');
        $this->addSql('ALTER TABLE details DROP FOREIGN KEY FK_72260B8A8805AB2F');
        $this->addSql('ALTER TABLE signalement DROP FOREIGN KEY FK_F4B551148805AB2F');
        $this->addSql('ALTER TABLE user_annonce DROP FOREIGN KEY FK_AE588DEF8805AB2F');
        $this->addSql('ALTER TABLE annonce DROP FOREIGN KEY FK_F65593E512469DE2');
        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C112469DE2');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F65C5E57E');
        $this->addSql('ALTER TABLE signalement_image DROP FOREIGN KEY FK_4A502B9165C5E57E');
        $this->addSql('ALTER TABLE annonce DROP FOREIGN KEY FK_F65593E57E3C61F9');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FF624B39D');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FE92F8F78');
        $this->addSql('ALTER TABLE signalement DROP FOREIGN KEY FK_F4B551147E3C61F9');
        $this->addSql('ALTER TABLE user_annonce DROP FOREIGN KEY FK_AE588DEFA76ED395');
        $this->addSql('DROP TABLE annonce');
        $this->addSql('DROP TABLE annonce_image');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE details');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE signalement');
        $this->addSql('DROP TABLE signalement_image');
        $this->addSql('DROP TABLE user');
    }
}
