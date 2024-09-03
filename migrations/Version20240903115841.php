<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240903115841 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE remise ADD COLUMN cumulable BOOLEAN DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__remise AS SELECT id, type_remise_id, designation, pourcentage FROM remise');
        $this->addSql('DROP TABLE remise');
        $this->addSql('CREATE TABLE remise (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, type_remise_id INTEGER DEFAULT NULL, designation VARCHAR(100) NOT NULL, pourcentage INTEGER NOT NULL, CONSTRAINT FK_117A95C7FA81E289 FOREIGN KEY (type_remise_id) REFERENCES type_remise (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO remise (id, type_remise_id, designation, pourcentage) SELECT id, type_remise_id, designation, pourcentage FROM __temp__remise');
        $this->addSql('DROP TABLE __temp__remise');
        $this->addSql('CREATE INDEX IDX_117A95C7FA81E289 ON remise (type_remise_id)');
    }
}
