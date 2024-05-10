<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240510081214 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE emploi_du_temps (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, classe_id INTEGER DEFAULT NULL, CONSTRAINT FK_F86B32C18F5EA509 FOREIGN KEY (classe_id) REFERENCES classe_annee_scolaire (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_F86B32C18F5EA509 ON emploi_du_temps (classe_id)');
        $this->addSql('CREATE TABLE tranche_horaire (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, classe_id INTEGER NOT NULL, emploi_du_temps_id INTEGER DEFAULT NULL, professeur_id INTEGER DEFAULT NULL, jour DATE NOT NULL, debut TIME NOT NULL, fin TIME NOT NULL, CONSTRAINT FK_F5A404F98F5EA509 FOREIGN KEY (classe_id) REFERENCES classe_annee_scolaire (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_F5A404F9C13CD51E FOREIGN KEY (emploi_du_temps_id) REFERENCES emploi_du_temps (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_F5A404F9BAB22EE9 FOREIGN KEY (professeur_id) REFERENCES personnel (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_F5A404F98F5EA509 ON tranche_horaire (classe_id)');
        $this->addSql('CREATE INDEX IDX_F5A404F9C13CD51E ON tranche_horaire (emploi_du_temps_id)');
        $this->addSql('CREATE INDEX IDX_F5A404F9BAB22EE9 ON tranche_horaire (professeur_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE emploi_du_temps');
        $this->addSql('DROP TABLE tranche_horaire');
    }
}
