<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240828080058 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE eleve ADD COLUMN personne_acontacter1 VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE eleve ADD COLUMN personne_acontacter2 VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE eleve ADD COLUMN numero_contact1 VARCHAR(20) DEFAULT NULL');
        $this->addSql('ALTER TABLE eleve ADD COLUMN numero_contact2 VARCHAR(20) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__eleve AS SELECT id, classe_actuelle_id, nom, prenoms, nationalite, ecole_de_provenance, date_dinscription, matricule, lieu_de_naissance, photo, sexe, date_de_naissance, observations FROM eleve');
        $this->addSql('DROP TABLE eleve');
        $this->addSql('CREATE TABLE eleve (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, classe_actuelle_id INTEGER DEFAULT NULL, nom VARCHAR(100) NOT NULL, prenoms VARCHAR(255) NOT NULL, nationalite VARCHAR(100) NOT NULL, ecole_de_provenance VARCHAR(255) DEFAULT NULL, date_dinscription DATE NOT NULL, matricule VARCHAR(10) DEFAULT NULL, lieu_de_naissance VARCHAR(255) DEFAULT NULL, photo VARCHAR(255) DEFAULT NULL, sexe VARCHAR(10) NOT NULL, date_de_naissance DATETIME DEFAULT NULL, observations CLOB DEFAULT NULL, CONSTRAINT FK_ECA105F74A69A5D7 FOREIGN KEY (classe_actuelle_id) REFERENCES classe_annee_scolaire (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO eleve (id, classe_actuelle_id, nom, prenoms, nationalite, ecole_de_provenance, date_dinscription, matricule, lieu_de_naissance, photo, sexe, date_de_naissance, observations) SELECT id, classe_actuelle_id, nom, prenoms, nationalite, ecole_de_provenance, date_dinscription, matricule, lieu_de_naissance, photo, sexe, date_de_naissance, observations FROM __temp__eleve');
        $this->addSql('DROP TABLE __temp__eleve');
        $this->addSql('CREATE INDEX IDX_ECA105F74A69A5D7 ON eleve (classe_actuelle_id)');
    }
}