<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240710090111 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE classe ADD COLUMN montant INTEGER DEFAULT NULL');
        $this->addSql('ALTER TABLE inscription ADD COLUMN montant_restant INTEGER NOT NULL');
        $this->addSql('ALTER TABLE inscription ADD COLUMN montant_remis INTEGER NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__classe AS SELECT id, classe_superieure_id, niveau_id, nom FROM classe');
        $this->addSql('DROP TABLE classe');
        $this->addSql('CREATE TABLE classe (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, classe_superieure_id INTEGER DEFAULT NULL, niveau_id INTEGER DEFAULT NULL, nom VARCHAR(10) NOT NULL, CONSTRAINT FK_8F87BF963A43B889 FOREIGN KEY (classe_superieure_id) REFERENCES classe (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_8F87BF96B3E9C81 FOREIGN KEY (niveau_id) REFERENCES niveau (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO classe (id, classe_superieure_id, niveau_id, nom) SELECT id, classe_superieure_id, niveau_id, nom FROM __temp__classe');
        $this->addSql('DROP TABLE __temp__classe');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8F87BF963A43B889 ON classe (classe_superieure_id)');
        $this->addSql('CREATE INDEX IDX_8F87BF96B3E9C81 ON classe (niveau_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__inscription AS SELECT id, eleve_id, annee_scolaire_id, classe_id FROM inscription');
        $this->addSql('DROP TABLE inscription');
        $this->addSql('CREATE TABLE inscription (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, eleve_id INTEGER NOT NULL, annee_scolaire_id INTEGER NOT NULL, classe_id INTEGER NOT NULL, CONSTRAINT FK_5E90F6D6A6CC7B2 FOREIGN KEY (eleve_id) REFERENCES eleve (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_5E90F6D69331C741 FOREIGN KEY (annee_scolaire_id) REFERENCES annee_scolaire (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_5E90F6D68F5EA509 FOREIGN KEY (classe_id) REFERENCES classe_annee_scolaire (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO inscription (id, eleve_id, annee_scolaire_id, classe_id) SELECT id, eleve_id, annee_scolaire_id, classe_id FROM __temp__inscription');
        $this->addSql('DROP TABLE __temp__inscription');
        $this->addSql('CREATE INDEX IDX_5E90F6D6A6CC7B2 ON inscription (eleve_id)');
        $this->addSql('CREATE INDEX IDX_5E90F6D69331C741 ON inscription (annee_scolaire_id)');
        $this->addSql('CREATE INDEX IDX_5E90F6D68F5EA509 ON inscription (classe_id)');
    }
}
