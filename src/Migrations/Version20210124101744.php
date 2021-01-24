<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210124101744 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Add Partner table with upload';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE partner (id INT AUTO_INCREMENT NOT NULL, presentation LONGTEXT NOT NULL, link VARCHAR(255) DEFAULT NULL, filename_partner VARCHAR(255) DEFAULT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('DROP TABLE presentation_users');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE presentation_users (user_id INT NOT NULL, presentation_id INT NOT NULL, INDEX IDX_F2E65E48A76ED395 (user_id), UNIQUE INDEX UNIQ_F2E65E48AB627E8B (presentation_id), PRIMARY KEY(user_id, presentation_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE presentation_users ADD CONSTRAINT FK_F2E65E48A76ED395 FOREIGN KEY (user_id) REFERENCES presentation (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE presentation_users ADD CONSTRAINT FK_F2E65E48AB627E8B FOREIGN KEY (presentation_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('DROP TABLE partner');
    }
}
