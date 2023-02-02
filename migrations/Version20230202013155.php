<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230202013155 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE "Cart_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE cart_details_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE "Cart" (id INT NOT NULL, user_cart_id INT NOT NULL, reference VARCHAR(255) NOT NULL, fullname VARCHAR(255) NOT NULL, carriername VARCHAR(255) NOT NULL, carrierprice DOUBLE PRECISION NOT NULL, deleveryaddress TEXT NOT NULL, ispaid BOOLEAN NOT NULL, moreinformations TEXT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, quantity INT NOT NULL, sub_total_ht DOUBLE PRECISION NOT NULL, taxe DOUBLE PRECISION NOT NULL, sub_total_ttc DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_AB91278942D8D3B5 ON "Cart" (user_cart_id)');
        $this->addSql('CREATE TABLE cart_details (id INT NOT NULL, carts_id INT NOT NULL, productname VARCHAR(255) NOT NULL, producprice DOUBLE PRECISION NOT NULL, quantity INT NOT NULL, sub_total_ht DOUBLE PRECISION NOT NULL, taxe DOUBLE PRECISION NOT NULL, sub_total_ttc DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_89FCC38DBCB5C6F5 ON cart_details (carts_id)');
        $this->addSql('ALTER TABLE "Cart" ADD CONSTRAINT FK_AB91278942D8D3B5 FOREIGN KEY (user_cart_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cart_details ADD CONSTRAINT FK_89FCC38DBCB5C6F5 FOREIGN KEY (carts_id) REFERENCES "Cart" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "order" ADD quantity INT NOT NULL');
        $this->addSql('ALTER TABLE "order" ADD sub_total_ht DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE "order" ADD taxe DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE "order" ADD sub_total_ttc DOUBLE PRECISION NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE "Cart_id_seq" CASCADE');
        $this->addSql('DROP SEQUENCE cart_details_id_seq CASCADE');
        $this->addSql('ALTER TABLE "Cart" DROP CONSTRAINT FK_AB91278942D8D3B5');
        $this->addSql('ALTER TABLE cart_details DROP CONSTRAINT FK_89FCC38DBCB5C6F5');
        $this->addSql('DROP TABLE "Cart"');
        $this->addSql('DROP TABLE cart_details');
        $this->addSql('ALTER TABLE "order" DROP quantity');
        $this->addSql('ALTER TABLE "order" DROP sub_total_ht');
        $this->addSql('ALTER TABLE "order" DROP taxe');
        $this->addSql('ALTER TABLE "order" DROP sub_total_ttc');
    }
}
