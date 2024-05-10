<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240509120613 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annee_scolaire ADD COLUMN designation VARCHAR(10) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__annee_scolaire AS SELECT id, debut, fin, active FROM annee_scolaire');
        $this->addSql('DROP TABLE annee_scolaire');
        $this->addSql('CREATE TABLE annee_scolaire (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, debut DATE NOT NULL, fin DATE NOT NULL, active BOOLEAN NOT NULL)');
        $this->addSql('INSERT INTO annee_scolaire (id, debut, fin, active) SELECT id, debut, fin, active FROM __temp__annee_scolaire');
        $this->addSql('DROP TABLE __temp__annee_scolaire');
    }
}
