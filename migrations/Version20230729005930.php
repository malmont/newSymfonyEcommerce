<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230729005930 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE collection_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE collections_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE collections (id INT NOT NULL, budget_collection DOUBLE PRECISION NOT NULL, start_date_collection TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, end_date_collection TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, del BOOLEAN NOT NULL, nom_collection VARCHAR(255) NOT NULL, photo_collection VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('DROP TABLE collection');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE collections_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE collection_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE collection (id INT NOT NULL, budget_collection DOUBLE PRECISION NOT NULL, start_date_collection TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, end_date_time TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, del BOOLEAN NOT NULL, nom_collection VARCHAR(255) NOT NULL, num_collection INT NOT NULL, photo_collection VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('DROP TABLE collections');
    }
}
