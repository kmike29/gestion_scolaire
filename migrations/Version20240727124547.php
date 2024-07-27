<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240727124547 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__inscription AS SELECT id, eleve_id, classe_id FROM inscription');
        $this->addSql('DROP TABLE inscription');
        $this->addSql('CREATE TABLE inscription (
          id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
          eleve_id INTEGER NOT NULL,
          classe_id INTEGER NOT NULL,
          remise_id INTEGER DEFAULT NULL,
          CONSTRAINT FK_5E90F6D6A6CC7B2 FOREIGN KEY (eleve_id) REFERENCES eleve (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE,
          CONSTRAINT FK_5E90F6D68F5EA509 FOREIGN KEY (classe_id) REFERENCES classe_annee_scolaire (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE,
          CONSTRAINT FK_5E90F6D64E47A399 FOREIGN KEY (remise_id) REFERENCES remise (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        )');
        $this->addSql('INSERT INTO inscription (id, eleve_id, classe_id)
        SELECT
          id,
          eleve_id,
          classe_id
        FROM
          __temp__inscription');
        $this->addSql('DROP TABLE __temp__inscription');
        $this->addSql('CREATE INDEX IDX_5E90F6D68F5EA509 ON inscription (classe_id)');
        $this->addSql('CREATE INDEX IDX_5E90F6D6A6CC7B2 ON inscription (eleve_id)');
        $this->addSql('CREATE INDEX IDX_5E90F6D64E47A399 ON inscription (remise_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__inscription AS SELECT id, eleve_id, classe_id FROM inscription');
        $this->addSql('DROP TABLE inscription');
        $this->addSql('CREATE TABLE inscription (
          id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
          eleve_id INTEGER NOT NULL,
          classe_id INTEGER NOT NULL,
          CONSTRAINT FK_5E90F6D6A6CC7B2 FOREIGN KEY (eleve_id) REFERENCES eleve (id) NOT DEFERRABLE INITIALLY IMMEDIATE,
          CONSTRAINT FK_5E90F6D68F5EA509 FOREIGN KEY (classe_id) REFERENCES classe_annee_scolaire (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        )');
        $this->addSql('INSERT INTO inscription (id, eleve_id, classe_id)
        SELECT
          id,
          eleve_id,
          classe_id
        FROM
          __temp__inscription');
        $this->addSql('DROP TABLE __temp__inscription');
        $this->addSql('CREATE INDEX IDX_5E90F6D6A6CC7B2 ON inscription (eleve_id)');
        $this->addSql('CREATE INDEX IDX_5E90F6D68F5EA509 ON inscription (classe_id)');
    }
}
