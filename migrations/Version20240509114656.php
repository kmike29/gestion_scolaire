<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240509114656 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE eleve_tuteur (eleve_id INTEGER NOT NULL, tuteur_id INTEGER NOT NULL, PRIMARY KEY(eleve_id, tuteur_id), CONSTRAINT FK_8F8818A9A6CC7B2 FOREIGN KEY (eleve_id) REFERENCES eleve (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_8F8818A986EC68D8 FOREIGN KEY (tuteur_id) REFERENCES tuteur (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_8F8818A9A6CC7B2 ON eleve_tuteur (eleve_id)');
        $this->addSql('CREATE INDEX IDX_8F8818A986EC68D8 ON eleve_tuteur (tuteur_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE eleve_tuteur');
    }
}
