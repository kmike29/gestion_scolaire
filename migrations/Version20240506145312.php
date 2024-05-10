<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240506145312 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annee_scolaire ADD COLUMN active BOOLEAN NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__annee_scolaire AS SELECT id, debut, fin FROM annee_scolaire');
        $this->addSql('DROP TABLE annee_scolaire');
        $this->addSql('CREATE TABLE annee_scolaire (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, debut DATE NOT NULL, fin DATE NOT NULL)');
        $this->addSql('INSERT INTO annee_scolaire (id, debut, fin) SELECT id, debut, fin FROM __temp__annee_scolaire');
        $this->addSql('DROP TABLE __temp__annee_scolaire');
    }
}
