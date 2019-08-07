<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190807092732 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE skill ADD created_at DATETIME DEFAULT NULL, CHANGE logo filename VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE project ADD created_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE profil CHANGE filename filename VARCHAR(255) DEFAULT NULL, CHANGE created_at created_at DATETIME DEFAULT NULL' );
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE profil CHANGE filename filename VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE created_at created_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE project DROP created_at');
        $this->addSql('ALTER TABLE skill DROP created_at, CHANGE filename logo VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci');
    }
}
