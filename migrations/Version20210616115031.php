<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210616115031 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annonce CHANGE category_id category_id INT DEFAULT NULL, CHANGE owner_id owner_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE annonce_image CHANGE annonce_id annonce_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE bookmark CHANGE user_id user_id INT DEFAULT NULL, CHANGE annonce_id annonce_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE message CHANGE sender_id sender_id INT DEFAULT NULL, CHANGE recipient_id recipient_id INT DEFAULT NULL, CHANGE signalement_id signalement_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE signalement CHANGE annonce_id annonce_id INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annonce CHANGE category_id category_id INT NOT NULL, CHANGE owner_id owner_id INT NOT NULL');
        $this->addSql('ALTER TABLE annonce_image CHANGE annonce_id annonce_id INT NOT NULL');
        $this->addSql('ALTER TABLE bookmark CHANGE user_id user_id INT NOT NULL, CHANGE annonce_id annonce_id INT NOT NULL');
        $this->addSql('ALTER TABLE message CHANGE sender_id sender_id INT NOT NULL, CHANGE recipient_id recipient_id INT NOT NULL, CHANGE signalement_id signalement_id INT NOT NULL');
        $this->addSql('ALTER TABLE signalement CHANGE annonce_id annonce_id INT NOT NULL');
    }
}
