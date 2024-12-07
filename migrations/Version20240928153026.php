<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240928153026 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE annee_scolaire (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, debut DATE NOT NULL, fin DATE NOT NULL, active BOOLEAN NOT NULL, designation VARCHAR(10) NOT NULL)');
        $this->addSql('CREATE TABLE classe (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, classe_superieure_id INTEGER DEFAULT NULL, niveau_id INTEGER DEFAULT NULL, ecole_id INTEGER DEFAULT NULL, nom VARCHAR(10) NOT NULL, frais_scolarite_de_base INTEGER NOT NULL, frais_inscription_de_base INTEGER NOT NULL, CONSTRAINT FK_8F87BF963A43B889 FOREIGN KEY (classe_superieure_id) REFERENCES classe (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_8F87BF96B3E9C81 FOREIGN KEY (niveau_id) REFERENCES niveau (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_8F87BF9677EF1B1E FOREIGN KEY (ecole_id) REFERENCES ecole (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8F87BF963A43B889 ON classe (classe_superieure_id)');
        $this->addSql('CREATE INDEX IDX_8F87BF96B3E9C81 ON classe (niveau_id)');
        $this->addSql('CREATE INDEX IDX_8F87BF9677EF1B1E ON classe (ecole_id)');
        $this->addSql('CREATE TABLE classe_annee_scolaire (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, annee_scolaire_id INTEGER NOT NULL, classe_id INTEGER DEFAULT NULL, ecole_id INTEGER DEFAULT NULL, frais_inscription INTEGER NOT NULL, frais_scolarite INTEGER NOT NULL, CONSTRAINT FK_D20826DC9331C741 FOREIGN KEY (annee_scolaire_id) REFERENCES annee_scolaire (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_D20826DC8F5EA509 FOREIGN KEY (classe_id) REFERENCES classe (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_D20826DC77EF1B1E FOREIGN KEY (ecole_id) REFERENCES ecole (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_D20826DC9331C741 ON classe_annee_scolaire (annee_scolaire_id)');
        $this->addSql('CREATE INDEX IDX_D20826DC8F5EA509 ON classe_annee_scolaire (classe_id)');
        $this->addSql('CREATE INDEX IDX_D20826DC77EF1B1E ON classe_annee_scolaire (ecole_id)');
        $this->addSql('CREATE TABLE classe_annee_scolaire_personnel (classe_annee_scolaire_id INTEGER NOT NULL, personnel_id INTEGER NOT NULL, PRIMARY KEY(classe_annee_scolaire_id, personnel_id), CONSTRAINT FK_B05FCFF42FD702A0 FOREIGN KEY (classe_annee_scolaire_id) REFERENCES classe_annee_scolaire (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_B05FCFF41C109075 FOREIGN KEY (personnel_id) REFERENCES personnel (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_B05FCFF42FD702A0 ON classe_annee_scolaire_personnel (classe_annee_scolaire_id)');
        $this->addSql('CREATE INDEX IDX_B05FCFF41C109075 ON classe_annee_scolaire_personnel (personnel_id)');
        $this->addSql('CREATE TABLE classe_matiere (id VARCHAR(255) NOT NULL, classe_id INTEGER NOT NULL, matiere_id INTEGER NOT NULL, coefficient INTEGER NOT NULL, PRIMARY KEY(id), CONSTRAINT FK_EB8D372B8F5EA509 FOREIGN KEY (classe_id) REFERENCES classe (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_EB8D372BF46CD258 FOREIGN KEY (matiere_id) REFERENCES matiere (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_EB8D372B8F5EA509 ON classe_matiere (classe_id)');
        $this->addSql('CREATE INDEX IDX_EB8D372BF46CD258 ON classe_matiere (matiere_id)');
        $this->addSql('CREATE TABLE ecole (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nom VARCHAR(100) NOT NULL, adresse VARCHAR(150) DEFAULT NULL, contact VARCHAR(50) NOT NULL)');
        $this->addSql('CREATE TABLE ecole_personnel (ecole_id INTEGER NOT NULL, personnel_id INTEGER NOT NULL, PRIMARY KEY(ecole_id, personnel_id), CONSTRAINT FK_7B247C5077EF1B1E FOREIGN KEY (ecole_id) REFERENCES ecole (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_7B247C501C109075 FOREIGN KEY (personnel_id) REFERENCES personnel (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_7B247C5077EF1B1E ON ecole_personnel (ecole_id)');
        $this->addSql('CREATE INDEX IDX_7B247C501C109075 ON ecole_personnel (personnel_id)');
        $this->addSql('CREATE TABLE eleve (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, classe_actuelle_id INTEGER DEFAULT NULL, ecole_id INTEGER DEFAULT NULL, nom VARCHAR(100) NOT NULL, prenoms VARCHAR(255) NOT NULL, nationalite VARCHAR(100) DEFAULT NULL, ecole_de_provenance VARCHAR(255) DEFAULT NULL, matricule VARCHAR(10) DEFAULT NULL, lieu_de_naissance VARCHAR(255) DEFAULT NULL, photo VARCHAR(255) DEFAULT NULL, sexe VARCHAR(10) NOT NULL, date_de_naissance DATETIME DEFAULT NULL, observations CLOB DEFAULT NULL, personne_acontacter1 VARCHAR(255) DEFAULT NULL, personne_acontacter2 VARCHAR(255) DEFAULT NULL, numero_contact1 VARCHAR(20) DEFAULT NULL, numero_contact2 VARCHAR(20) DEFAULT NULL, date_dinscription DATE DEFAULT NULL, inscription_complete BOOLEAN DEFAULT NULL, exemption BOOLEAN DEFAULT NULL, CONSTRAINT FK_ECA105F74A69A5D7 FOREIGN KEY (classe_actuelle_id) REFERENCES classe_annee_scolaire (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_ECA105F777EF1B1E FOREIGN KEY (ecole_id) REFERENCES ecole (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_ECA105F74A69A5D7 ON eleve (classe_actuelle_id)');
        $this->addSql('CREATE INDEX IDX_ECA105F777EF1B1E ON eleve (ecole_id)');
        $this->addSql('CREATE TABLE eleve_tuteur (eleve_id INTEGER NOT NULL, tuteur_id INTEGER NOT NULL, PRIMARY KEY(eleve_id, tuteur_id), CONSTRAINT FK_8F8818A9A6CC7B2 FOREIGN KEY (eleve_id) REFERENCES eleve (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_8F8818A986EC68D8 FOREIGN KEY (tuteur_id) REFERENCES tuteur (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_8F8818A9A6CC7B2 ON eleve_tuteur (eleve_id)');
        $this->addSql('CREATE INDEX IDX_8F8818A986EC68D8 ON eleve_tuteur (tuteur_id)');
        $this->addSql('CREATE TABLE emploi_du_temps (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, classe_id INTEGER DEFAULT NULL, CONSTRAINT FK_F86B32C18F5EA509 FOREIGN KEY (classe_id) REFERENCES classe_annee_scolaire (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_F86B32C18F5EA509 ON emploi_du_temps (classe_id)');
        $this->addSql('CREATE TABLE facture (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, annee_scolaire_id INTEGER DEFAULT NULL, ecole_id INTEGER DEFAULT NULL, reference VARCHAR(100) NOT NULL, date_facture DATE DEFAULT NULL, CONSTRAINT FK_FE8664109331C741 FOREIGN KEY (annee_scolaire_id) REFERENCES annee_scolaire (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_FE86641077EF1B1E FOREIGN KEY (ecole_id) REFERENCES ecole (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_FE8664109331C741 ON facture (annee_scolaire_id)');
        $this->addSql('CREATE INDEX IDX_FE86641077EF1B1E ON facture (ecole_id)');
        $this->addSql('CREATE TABLE inscription (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, classe_id INTEGER NOT NULL, remise_id INTEGER DEFAULT NULL, eleve_id INTEGER NOT NULL, ecole_id INTEGER DEFAULT NULL, paiement_unique BOOLEAN NOT NULL, CONSTRAINT FK_5E90F6D68F5EA509 FOREIGN KEY (classe_id) REFERENCES classe_annee_scolaire (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_5E90F6D64E47A399 FOREIGN KEY (remise_id) REFERENCES remise (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_5E90F6D6A6CC7B2 FOREIGN KEY (eleve_id) REFERENCES eleve (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_5E90F6D677EF1B1E FOREIGN KEY (ecole_id) REFERENCES ecole (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_5E90F6D68F5EA509 ON inscription (classe_id)');
        $this->addSql('CREATE INDEX IDX_5E90F6D64E47A399 ON inscription (remise_id)');
        $this->addSql('CREATE INDEX IDX_5E90F6D6A6CC7B2 ON inscription (eleve_id)');
        $this->addSql('CREATE INDEX IDX_5E90F6D677EF1B1E ON inscription (ecole_id)');
        $this->addSql('CREATE TABLE matiere (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nom VARCHAR(100) NOT NULL, description CLOB DEFAULT NULL)');
        $this->addSql('CREATE TABLE niveau (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nom VARCHAR(30) NOT NULL)');
        $this->addSql('CREATE TABLE paiement (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, inscription_id INTEGER NOT NULL, facture_id INTEGER DEFAULT NULL, type VARCHAR(20) NOT NULL, montant INTEGER NOT NULL, date_de_transaction DATETIME DEFAULT NULL, CONSTRAINT FK_B1DC7A1E5DAC5993 FOREIGN KEY (inscription_id) REFERENCES inscription (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_B1DC7A1E7F2DEE08 FOREIGN KEY (facture_id) REFERENCES facture (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_B1DC7A1E5DAC5993 ON paiement (inscription_id)');
        $this->addSql('CREATE INDEX IDX_B1DC7A1E7F2DEE08 ON paiement (facture_id)');
        $this->addSql('CREATE TABLE personnel (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nom VARCHAR(100) NOT NULL, prenoms VARCHAR(255) NOT NULL, matricule VARCHAR(10) NOT NULL, date_de_naissance DATE NOT NULL, date_ajout DATE NOT NULL, acte_de_naissance VARCHAR(255) DEFAULT NULL, cv VARCHAR(255) DEFAULT NULL, numero_cnss VARCHAR(100) DEFAULT NULL, compte_bancaire VARCHAR(255) DEFAULT NULL, diplomes_academiques VARCHAR(255) DEFAULT NULL, diplomes_professionnels VARCHAR(255) DEFAULT NULL)');
        $this->addSql('CREATE TABLE remise (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, type_remise_id INTEGER DEFAULT NULL, designation VARCHAR(100) NOT NULL, pourcentage INTEGER NOT NULL, cumulable BOOLEAN DEFAULT NULL, CONSTRAINT FK_117A95C7FA81E289 FOREIGN KEY (type_remise_id) REFERENCES type_remise (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_117A95C7FA81E289 ON remise (type_remise_id)');
        $this->addSql('CREATE TABLE tranche_horaire (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, emploi_du_temps_id INTEGER DEFAULT NULL, professeur_id INTEGER DEFAULT NULL, matiere_id VARCHAR(255) NOT NULL, jour DATE NOT NULL, debut TIME NOT NULL, fin TIME NOT NULL, CONSTRAINT FK_F5A404F9C13CD51E FOREIGN KEY (emploi_du_temps_id) REFERENCES emploi_du_temps (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_F5A404F9BAB22EE9 FOREIGN KEY (professeur_id) REFERENCES personnel (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_F5A404F9F46CD258 FOREIGN KEY (matiere_id) REFERENCES classe_matiere (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_F5A404F9C13CD51E ON tranche_horaire (emploi_du_temps_id)');
        $this->addSql('CREATE INDEX IDX_F5A404F9BAB22EE9 ON tranche_horaire (professeur_id)');
        $this->addSql('CREATE INDEX IDX_F5A404F9F46CD258 ON tranche_horaire (matiere_id)');
        $this->addSql('CREATE TABLE tuteur (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nom VARCHAR(100) NOT NULL, prenoms VARCHAR(255) NOT NULL, relation VARCHAR(50) NOT NULL, telephone VARCHAR(15) NOT NULL, metier VARCHAR(255) NOT NULL, sexe VARCHAR(10) NOT NULL)');
        $this->addSql('CREATE TABLE type_remise (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, designation VARCHAR(50) NOT NULL)');
        $this->addSql('CREATE TABLE utilisateur (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_USERNAME ON utilisateur (username)');
        $this->addSql('CREATE TABLE messenger_messages (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, body CLOB NOT NULL, headers CLOB NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , available_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , delivered_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE annee_scolaire');
        $this->addSql('DROP TABLE classe');
        $this->addSql('DROP TABLE classe_annee_scolaire');
        $this->addSql('DROP TABLE classe_annee_scolaire_personnel');
        $this->addSql('DROP TABLE classe_matiere');
        $this->addSql('DROP TABLE ecole');
        $this->addSql('DROP TABLE ecole_personnel');
        $this->addSql('DROP TABLE eleve');
        $this->addSql('DROP TABLE eleve_tuteur');
        $this->addSql('DROP TABLE emploi_du_temps');
        $this->addSql('DROP TABLE facture');
        $this->addSql('DROP TABLE inscription');
        $this->addSql('DROP TABLE matiere');
        $this->addSql('DROP TABLE niveau');
        $this->addSql('DROP TABLE paiement');
        $this->addSql('DROP TABLE personnel');
        $this->addSql('DROP TABLE remise');
        $this->addSql('DROP TABLE tranche_horaire');
        $this->addSql('DROP TABLE tuteur');
        $this->addSql('DROP TABLE type_remise');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
