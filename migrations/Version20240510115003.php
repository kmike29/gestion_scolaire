<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240510115003 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__tranche_horaire AS SELECT id, emploi_du_temps_id, professeur_id, matiere_id, jour, debut, fin FROM tranche_horaire');
        $this->addSql('DROP TABLE tranche_horaire');
        $this->addSql('CREATE TABLE tranche_horaire (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, emploi_du_temps_id INTEGER DEFAULT NULL, professeur_id INTEGER DEFAULT NULL, matiere_id VARCHAR(255) NOT NULL, jour DATE NOT NULL, debut TIME NOT NULL, fin TIME NOT NULL, CONSTRAINT FK_F5A404F9C13CD51E FOREIGN KEY (emploi_du_temps_id) REFERENCES emploi_du_temps (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_F5A404F9BAB22EE9 FOREIGN KEY (professeur_id) REFERENCES personnel (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_F5A404F9F46CD258 FOREIGN KEY (matiere_id) REFERENCES classe_matiere (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO tranche_horaire (id, emploi_du_temps_id, professeur_id, matiere_id, jour, debut, fin) SELECT id, emploi_du_temps_id, professeur_id, matiere_id, jour, debut, fin FROM __temp__tranche_horaire');
        $this->addSql('DROP TABLE __temp__tranche_horaire');
        $this->addSql('CREATE INDEX IDX_F5A404F9F46CD258 ON tranche_horaire (matiere_id)');
        $this->addSql('CREATE INDEX IDX_F5A404F9C13CD51E ON tranche_horaire (emploi_du_temps_id)');
        $this->addSql('CREATE INDEX IDX_F5A404F9BAB22EE9 ON tranche_horaire (professeur_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__tranche_horaire AS SELECT id, emploi_du_temps_id, professeur_id, matiere_id, jour, debut, fin FROM tranche_horaire');
        $this->addSql('DROP TABLE tranche_horaire');
        $this->addSql('CREATE TABLE tranche_horaire (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, emploi_du_temps_id INTEGER DEFAULT NULL, professeur_id INTEGER DEFAULT NULL, matiere_id VARCHAR(255) NOT NULL, classe_id INTEGER NOT NULL, jour DATE NOT NULL, debut TIME NOT NULL, fin TIME NOT NULL, CONSTRAINT FK_F5A404F9C13CD51E FOREIGN KEY (emploi_du_temps_id) REFERENCES emploi_du_temps (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_F5A404F9BAB22EE9 FOREIGN KEY (professeur_id) REFERENCES personnel (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_F5A404F9F46CD258 FOREIGN KEY (matiere_id) REFERENCES classe_matiere (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_F5A404F98F5EA509 FOREIGN KEY (classe_id) REFERENCES classe_annee_scolaire (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO tranche_horaire (id, emploi_du_temps_id, professeur_id, matiere_id, jour, debut, fin) SELECT id, emploi_du_temps_id, professeur_id, matiere_id, jour, debut, fin FROM __temp__tranche_horaire');
        $this->addSql('DROP TABLE __temp__tranche_horaire');
        $this->addSql('CREATE INDEX IDX_F5A404F9C13CD51E ON tranche_horaire (emploi_du_temps_id)');
        $this->addSql('CREATE INDEX IDX_F5A404F9BAB22EE9 ON tranche_horaire (professeur_id)');
        $this->addSql('CREATE INDEX IDX_F5A404F9F46CD258 ON tranche_horaire (matiere_id)');
        $this->addSql('CREATE INDEX IDX_F5A404F98F5EA509 ON tranche_horaire (classe_id)');
    }
}