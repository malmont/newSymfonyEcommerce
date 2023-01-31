<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230125023847 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE tags_product_id_seq CASCADE');
        $this->addSql('ALTER TABLE tags_product_product DROP CONSTRAINT fk_90acd5ef273d7abb');
        $this->addSql('ALTER TABLE tags_product_product DROP CONSTRAINT fk_90acd5ef4584665a');
        $this->addSql('DROP TABLE tags_product_product');
        $this->addSql('DROP TABLE tags_product');
        $this->addSql('ALTER TABLE product ADD quantity INT NOT NULL');
        $this->addSql('ALTER TABLE product ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE product ADD tags TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE product ADD slug VARCHAR(255) NOT NULL');
        $this->addSql('COMMENT ON COLUMN product.created_at IS \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE tags_product_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE tags_product_product (tags_product_id INT NOT NULL, product_id INT NOT NULL, PRIMARY KEY(tags_product_id, product_id))');
        $this->addSql('CREATE INDEX idx_90acd5ef4584665a ON tags_product_product (product_id)');
        $this->addSql('CREATE INDEX idx_90acd5ef273d7abb ON tags_product_product (tags_product_id)');
        $this->addSql('CREATE TABLE tags_product (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE tags_product_product ADD CONSTRAINT fk_90acd5ef273d7abb FOREIGN KEY (tags_product_id) REFERENCES tags_product (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tags_product_product ADD CONSTRAINT fk_90acd5ef4584665a FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE product DROP quantity');
        $this->addSql('ALTER TABLE product DROP created_at');
        $this->addSql('ALTER TABLE product DROP tags');
        $this->addSql('ALTER TABLE product DROP slug');
    }
}
