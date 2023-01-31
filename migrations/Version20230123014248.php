<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230123014248 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE adress_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE adress (id INT NOT NULL, user_adress_id INT NOT NULL, fullname VARCHAR(255) NOT NULL, company VARCHAR(255) DEFAULT NULL, address TEXT NOT NULL, complement TEXT DEFAULT NULL, phone INT NOT NULL, city VARCHAR(255) NOT NULL, codepostal INT NOT NULL, country VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_5CECC7BE84667448 ON adress (user_adress_id)');
        $this->addSql('ALTER TABLE adress ADD CONSTRAINT FK_5CECC7BE84667448 FOREIGN KEY (user_adress_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE adress_id_seq CASCADE');
        $this->addSql('ALTER TABLE adress DROP CONSTRAINT FK_5CECC7BE84667448');
        $this->addSql('DROP TABLE adress');
    }
}
