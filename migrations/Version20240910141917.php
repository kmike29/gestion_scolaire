<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240910141917 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__facture AS SELECT id, reference, date_facture FROM facture');
        $this->addSql('DROP TABLE facture');
        $this->addSql('CREATE TABLE facture (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, annee_scolaire_id INTEGER DEFAULT NULL, reference VARCHAR(100) NOT NULL, date_facture DATE DEFAULT NULL, CONSTRAINT FK_FE8664109331C741 FOREIGN KEY (annee_scolaire_id) REFERENCES annee_scolaire (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO facture (id, reference, date_facture) SELECT id, reference, date_facture FROM __temp__facture');
        $this->addSql('DROP TABLE __temp__facture');
        $this->addSql('CREATE INDEX IDX_FE8664109331C741 ON facture (annee_scolaire_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__facture AS SELECT id, reference, date_facture FROM facture');
        $this->addSql('DROP TABLE facture');
        $this->addSql('CREATE TABLE facture (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, reference VARCHAR(100) NOT NULL, date_facture DATE DEFAULT NULL)');
        $this->addSql('INSERT INTO facture (id, reference, date_facture) SELECT id, reference, date_facture FROM __temp__facture');
        $this->addSql('DROP TABLE __temp__facture');
    }
}
