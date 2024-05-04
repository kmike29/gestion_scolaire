<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240504155304 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__classe_matiere AS SELECT id, classe_id, matiere_id, coefficient FROM classe_matiere');
        $this->addSql('DROP TABLE classe_matiere');
        $this->addSql('CREATE TABLE classe_matiere (id VARCHAR(255) NOT NULL, classe_id INTEGER NOT NULL, matiere_id INTEGER NOT NULL, coefficient INTEGER NOT NULL, PRIMARY KEY(id), CONSTRAINT FK_EB8D372B8F5EA509 FOREIGN KEY (classe_id) REFERENCES classe (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_EB8D372BF46CD258 FOREIGN KEY (matiere_id) REFERENCES matiere (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO classe_matiere (id, classe_id, matiere_id, coefficient) SELECT id, classe_id, matiere_id, coefficient FROM __temp__classe_matiere');
        $this->addSql('DROP TABLE __temp__classe_matiere');
        $this->addSql('CREATE INDEX IDX_EB8D372B8F5EA509 ON classe_matiere (classe_id)');
        $this->addSql('CREATE INDEX IDX_EB8D372BF46CD258 ON classe_matiere (matiere_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__classe_matiere AS SELECT id, classe_id, matiere_id, coefficient FROM classe_matiere');
        $this->addSql('DROP TABLE classe_matiere');
        $this->addSql('CREATE TABLE classe_matiere (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, classe_id INTEGER NOT NULL, matiere_id INTEGER NOT NULL, coefficient INTEGER NOT NULL, CONSTRAINT FK_EB8D372B8F5EA509 FOREIGN KEY (classe_id) REFERENCES classe (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_EB8D372BF46CD258 FOREIGN KEY (matiere_id) REFERENCES matiere (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO classe_matiere (id, classe_id, matiere_id, coefficient) SELECT id, classe_id, matiere_id, coefficient FROM __temp__classe_matiere');
        $this->addSql('DROP TABLE __temp__classe_matiere');
        $this->addSql('CREATE INDEX IDX_EB8D372B8F5EA509 ON classe_matiere (classe_id)');
        $this->addSql('CREATE INDEX IDX_EB8D372BF46CD258 ON classe_matiere (matiere_id)');
    }
}
