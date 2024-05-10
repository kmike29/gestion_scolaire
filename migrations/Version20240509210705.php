<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240509210705 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE personnel (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nom VARCHAR(100) NOT NULL, prenoms VARCHAR(255) NOT NULL, matricule VARCHAR(10) NOT NULL, date_de_naissance DATE NOT NULL, date_ajout DATE NOT NULL, acte_de_naissance VARCHAR(255) DEFAULT NULL, cv VARCHAR(255) DEFAULT NULL, numero_cnss VARCHAR(100) NOT NULL, compte_bancaire VARCHAR(255) DEFAULT NULL, diplomes_academiques VARCHAR(255) DEFAULT NULL, diplomes_professionnels VARCHAR(255) DEFAULT NULL)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE personnel');
    }
}
