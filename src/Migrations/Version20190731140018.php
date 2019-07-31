<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190731140018 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE project ADD profil_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EE275ED078 FOREIGN KEY (profil_id) REFERENCES profil (id)');
        $this->addSql('CREATE INDEX IDX_2FB3D0EE275ED078 ON project (profil_id)');
        $this->addSql('ALTER TABLE skill ADD profil_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE skill ADD CONSTRAINT FK_5E3DE477275ED078 FOREIGN KEY (profil_id) REFERENCES profil (id)');
        $this->addSql('CREATE INDEX IDX_5E3DE477275ED078 ON skill (profil_id)');
        $this->addSql('ALTER TABLE techno ADD project_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE techno ADD CONSTRAINT FK_3987EEDC166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
        $this->addSql('CREATE INDEX IDX_3987EEDC166D1F9C ON techno (project_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE project DROP FOREIGN KEY FK_2FB3D0EE275ED078');
        $this->addSql('DROP INDEX IDX_2FB3D0EE275ED078 ON project');
        $this->addSql('ALTER TABLE project DROP profil_id');
        $this->addSql('ALTER TABLE skill DROP FOREIGN KEY FK_5E3DE477275ED078');
        $this->addSql('DROP INDEX IDX_5E3DE477275ED078 ON skill');
        $this->addSql('ALTER TABLE skill DROP profil_id');
        $this->addSql('ALTER TABLE techno DROP FOREIGN KEY FK_3987EEDC166D1F9C');
        $this->addSql('DROP INDEX IDX_3987EEDC166D1F9C ON techno');
        $this->addSql('ALTER TABLE techno DROP project_id');
    }
}
