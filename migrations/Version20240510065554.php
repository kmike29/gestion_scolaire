<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240510065554 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE classe_annee_scolaire_personnel (classe_annee_scolaire_id INTEGER NOT NULL, personnel_id INTEGER NOT NULL, PRIMARY KEY(classe_annee_scolaire_id, personnel_id), CONSTRAINT FK_B05FCFF42FD702A0 FOREIGN KEY (classe_annee_scolaire_id) REFERENCES classe_annee_scolaire (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_B05FCFF41C109075 FOREIGN KEY (personnel_id) REFERENCES personnel (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_B05FCFF42FD702A0 ON classe_annee_scolaire_personnel (classe_annee_scolaire_id)');
        $this->addSql('CREATE INDEX IDX_B05FCFF41C109075 ON classe_annee_scolaire_personnel (personnel_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE classe_annee_scolaire_personnel');
    }
}
