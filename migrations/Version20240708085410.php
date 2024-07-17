<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240708085410 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__eleve AS SELECT id, nom, prenoms, date_de_naissance, nationalite, ecole_de_provenance, date_dinscription, matricule, lieu_de_naissance, photo, sexe FROM eleve');
        $this->addSql('DROP TABLE eleve');
        $this->addSql('CREATE TABLE eleve (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, classe_id INTEGER DEFAULT NULL, nom VARCHAR(100) NOT NULL, prenoms VARCHAR(255) NOT NULL, date_de_naissance DATE NOT NULL, nationalite VARCHAR(100) NOT NULL, ecole_de_provenance VARCHAR(255) DEFAULT NULL, date_dinscription DATE NOT NULL, matricule VARCHAR(10) NOT NULL, lieu_de_naissance VARCHAR(255) NOT NULL, photo VARCHAR(255) NOT NULL, sexe VARCHAR(10) NOT NULL, CONSTRAINT FK_ECA105F78F5EA509 FOREIGN KEY (classe_id) REFERENCES classe_annee_scolaire (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO eleve (id, nom, prenoms, date_de_naissance, nationalite, ecole_de_provenance, date_dinscription, matricule, lieu_de_naissance, photo, sexe) SELECT id, nom, prenoms, date_de_naissance, nationalite, ecole_de_provenance, date_dinscription, matricule, lieu_de_naissance, photo, sexe FROM __temp__eleve');
        $this->addSql('DROP TABLE __temp__eleve');
        $this->addSql('CREATE INDEX IDX_ECA105F78F5EA509 ON eleve (classe_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__eleve AS SELECT id, nom, prenoms, date_de_naissance, nationalite, ecole_de_provenance, date_dinscription, matricule, lieu_de_naissance, photo, sexe FROM eleve');
        $this->addSql('DROP TABLE eleve');
        $this->addSql('CREATE TABLE eleve (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nom VARCHAR(100) NOT NULL, prenoms VARCHAR(255) NOT NULL, date_de_naissance DATE NOT NULL, nationalite VARCHAR(100) NOT NULL, ecole_de_provenance VARCHAR(255) DEFAULT NULL, date_dinscription DATE NOT NULL, matricule VARCHAR(10) NOT NULL, lieu_de_naissance VARCHAR(255) NOT NULL, photo VARCHAR(255) NOT NULL, sexe VARCHAR(10) NOT NULL)');
        $this->addSql('INSERT INTO eleve (id, nom, prenoms, date_de_naissance, nationalite, ecole_de_provenance, date_dinscription, matricule, lieu_de_naissance, photo, sexe) SELECT id, nom, prenoms, date_de_naissance, nationalite, ecole_de_provenance, date_dinscription, matricule, lieu_de_naissance, photo, sexe FROM __temp__eleve');
        $this->addSql('DROP TABLE __temp__eleve');
    }
}
