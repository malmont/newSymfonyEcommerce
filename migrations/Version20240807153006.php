<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240807153006 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE commande_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE commande (id INT NOT NULL, collections_id INT DEFAULT NULL, budget DOUBLE PRECISION NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, name VARCHAR(255) DEFAULT NULL, photo VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_6EEAA67D242C7AD2 ON commande (collections_id)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D242C7AD2 FOREIGN KEY (collections_id) REFERENCES collections (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE commande_id_seq CASCADE');
        $this->addSql('ALTER TABLE commande DROP CONSTRAINT FK_6EEAA67D242C7AD2');
        $this->addSql('DROP TABLE commande');
    }
}
