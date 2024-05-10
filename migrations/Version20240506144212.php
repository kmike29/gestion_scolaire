<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240506144212 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE annee_scolaire (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, debut DATE NOT NULL, fin DATE NOT NULL)');
        $this->addSql('CREATE TABLE classe_annee_scolaire (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, annee_scolaire_id INTEGER NOT NULL, classe_id INTEGER DEFAULT NULL, CONSTRAINT FK_D20826DC9331C741 FOREIGN KEY (annee_scolaire_id) REFERENCES annee_scolaire (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_D20826DC8F5EA509 FOREIGN KEY (classe_id) REFERENCES classe (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_D20826DC9331C741 ON classe_annee_scolaire (annee_scolaire_id)');
        $this->addSql('CREATE INDEX IDX_D20826DC8F5EA509 ON classe_annee_scolaire (classe_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE annee_scolaire');
        $this->addSql('DROP TABLE classe_annee_scolaire');
    }
}
