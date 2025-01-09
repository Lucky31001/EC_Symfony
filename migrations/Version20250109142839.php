<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250109142839 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE book (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, description TEXT NOT NULL, pages INT NOT NULL, publication_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE book_category (book_id INT NOT NULL, category_id INT NOT NULL, PRIMARY KEY(book_id, category_id))');
        $this->addSql('CREATE INDEX IDX_1FB30F9816A2B381 ON book_category (book_id)');
        $this->addSql('CREATE INDEX IDX_1FB30F9812469DE2 ON book_category (category_id)');
        $this->addSql('CREATE TABLE book_read (id SERIAL NOT NULL, user_id INT DEFAULT NULL, book_id INT NOT NULL, rating NUMERIC(5, 2) DEFAULT NULL, description TEXT DEFAULT NULL, is_read BOOLEAN NOT NULL, cover VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_81CA0A6FA76ED395 ON book_read (user_id)');
        $this->addSql('CREATE INDEX IDX_81CA0A6F16A2B381 ON book_read (book_id)');
        $this->addSql('CREATE TABLE category (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, description TEXT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE "user" (id SERIAL NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON "user" (email)');
        $this->addSql('ALTER TABLE book_category ADD CONSTRAINT FK_1FB30F9816A2B381 FOREIGN KEY (book_id) REFERENCES book (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE book_category ADD CONSTRAINT FK_1FB30F9812469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE book_read ADD CONSTRAINT FK_81CA0A6FA76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE book_read ADD CONSTRAINT FK_81CA0A6F16A2B381 FOREIGN KEY (book_id) REFERENCES book (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE book_category DROP CONSTRAINT FK_1FB30F9816A2B381');
        $this->addSql('ALTER TABLE book_category DROP CONSTRAINT FK_1FB30F9812469DE2');
        $this->addSql('ALTER TABLE book_read DROP CONSTRAINT FK_81CA0A6FA76ED395');
        $this->addSql('ALTER TABLE book_read DROP CONSTRAINT FK_81CA0A6F16A2B381');
        $this->addSql('DROP TABLE book');
        $this->addSql('DROP TABLE book_category');
        $this->addSql('DROP TABLE book_read');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE "user"');
    }
}
