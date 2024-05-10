<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240509125553 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE eleve ADD COLUMN sexe VARCHAR(10) NOT NULL');
        $this->addSql('ALTER TABLE tuteur ADD COLUMN sexe VARCHAR(10) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__eleve AS SELECT id, nom, prenoms, date_de_naissance, nationalite, ecole_de_provenance, date_dinscription, matricule, lieu_de_naissance, photo FROM eleve');
        $this->addSql('DROP TABLE eleve');
        $this->addSql('CREATE TABLE eleve (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nom VARCHAR(100) NOT NULL, prenoms VARCHAR(255) NOT NULL, date_de_naissance DATE NOT NULL, nationalite VARCHAR(100) NOT NULL, ecole_de_provenance VARCHAR(255) DEFAULT NULL, date_dinscription DATE NOT NULL, matricule VARCHAR(10) NOT NULL, lieu_de_naissance VARCHAR(255) NOT NULL, photo VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO eleve (id, nom, prenoms, date_de_naissance, nationalite, ecole_de_provenance, date_dinscription, matricule, lieu_de_naissance, photo) SELECT id, nom, prenoms, date_de_naissance, nationalite, ecole_de_provenance, date_dinscription, matricule, lieu_de_naissance, photo FROM __temp__eleve');
        $this->addSql('DROP TABLE __temp__eleve');
        $this->addSql('CREATE TEMPORARY TABLE __temp__tuteur AS SELECT id, nom, prenoms, relation, telephone, metier FROM tuteur');
        $this->addSql('DROP TABLE tuteur');
        $this->addSql('CREATE TABLE tuteur (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nom VARCHAR(100) NOT NULL, prenoms VARCHAR(255) NOT NULL, relation VARCHAR(50) NOT NULL, telephone VARCHAR(15) NOT NULL, metier VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO tuteur (id, nom, prenoms, relation, telephone, metier) SELECT id, nom, prenoms, relation, telephone, metier FROM __temp__tuteur');
        $this->addSql('DROP TABLE __temp__tuteur');
    }
}
