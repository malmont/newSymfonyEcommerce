<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230125003452 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE categories_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE product_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE related_product_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE reviews_product_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE tags_product_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE categories (id INT NOT NULL, name VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE product (id INT NOT NULL, name VARCHAR(255) NOT NULL, description TEXT NOT NULL, moreinformations TEXT NOT NULL, price DOUBLE PRECISION NOT NULL, isbestseller BOOLEAN NOT NULL, isnewarrival BOOLEAN DEFAULT NULL, isfeatured BOOLEAN DEFAULT NULL, isspecialoffer BOOLEAN DEFAULT NULL, image VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE product_categories (product_id INT NOT NULL, categories_id INT NOT NULL, PRIMARY KEY(product_id, categories_id))');
        $this->addSql('CREATE INDEX IDX_A99419434584665A ON product_categories (product_id)');
        $this->addSql('CREATE INDEX IDX_A9941943A21214B7 ON product_categories (categories_id)');
        $this->addSql('CREATE TABLE related_product (id INT NOT NULL, product_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_EC53CE084584665A ON related_product (product_id)');
        $this->addSql('CREATE TABLE reviews_product (id INT NOT NULL, user_review_id INT NOT NULL, product_reviews_id INT NOT NULL, note INT NOT NULL, comment TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_E0851D6C3ECE1B7F ON reviews_product (user_review_id)');
        $this->addSql('CREATE INDEX IDX_E0851D6C13F58654 ON reviews_product (product_reviews_id)');
        $this->addSql('CREATE TABLE tags_product (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE tags_product_product (tags_product_id INT NOT NULL, product_id INT NOT NULL, PRIMARY KEY(tags_product_id, product_id))');
        $this->addSql('CREATE INDEX IDX_90ACD5EF273D7ABB ON tags_product_product (tags_product_id)');
        $this->addSql('CREATE INDEX IDX_90ACD5EF4584665A ON tags_product_product (product_id)');
        $this->addSql('ALTER TABLE product_categories ADD CONSTRAINT FK_A99419434584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE product_categories ADD CONSTRAINT FK_A9941943A21214B7 FOREIGN KEY (categories_id) REFERENCES categories (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE related_product ADD CONSTRAINT FK_EC53CE084584665A FOREIGN KEY (product_id) REFERENCES product (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE reviews_product ADD CONSTRAINT FK_E0851D6C3ECE1B7F FOREIGN KEY (user_review_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE reviews_product ADD CONSTRAINT FK_E0851D6C13F58654 FOREIGN KEY (product_reviews_id) REFERENCES product (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tags_product_product ADD CONSTRAINT FK_90ACD5EF273D7ABB FOREIGN KEY (tags_product_id) REFERENCES tags_product (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tags_product_product ADD CONSTRAINT FK_90ACD5EF4584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE categories_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE product_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE related_product_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE reviews_product_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE tags_product_id_seq CASCADE');
        $this->addSql('ALTER TABLE product_categories DROP CONSTRAINT FK_A99419434584665A');
        $this->addSql('ALTER TABLE product_categories DROP CONSTRAINT FK_A9941943A21214B7');
        $this->addSql('ALTER TABLE related_product DROP CONSTRAINT FK_EC53CE084584665A');
        $this->addSql('ALTER TABLE reviews_product DROP CONSTRAINT FK_E0851D6C3ECE1B7F');
        $this->addSql('ALTER TABLE reviews_product DROP CONSTRAINT FK_E0851D6C13F58654');
        $this->addSql('ALTER TABLE tags_product_product DROP CONSTRAINT FK_90ACD5EF273D7ABB');
        $this->addSql('ALTER TABLE tags_product_product DROP CONSTRAINT FK_90ACD5EF4584665A');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE product_categories');
        $this->addSql('DROP TABLE related_product');
        $this->addSql('DROP TABLE reviews_product');
        $this->addSql('DROP TABLE tags_product');
        $this->addSql('DROP TABLE tags_product_product');
    }
}
