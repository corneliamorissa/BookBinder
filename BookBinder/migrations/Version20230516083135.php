<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230516083135 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE books (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, number_of_pages INT NOT NULL, author VARCHAR(255) NOT NULL, isbn VARCHAR(255) NOT NULL, number_of_followers INT NOT NULL, library INT NOT NULL, rating NUMERIC(3, 1) NOT NULL, number_of_votes INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE libraries (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, street VARCHAR(255) NOT NULL, housenumber INT NOT NULL, postcode INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(50) NOT NULL, first_name VARCHAR(50) NOT NULL, last_name VARCHAR(50) NOT NULL, street VARCHAR(100) NOT NULL, house_number INT NOT NULL, postcode INT NOT NULL, birthdate DATE NOT NULL, private_account INT NOT NULL, avatar_id INT NOT NULL, roles JSON NOT NULL, password VARCHAR(256) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_book (id INT AUTO_INCREMENT NOT NULL, bookid INT NOT NULL, userid INT NOT NULL, comment VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_password (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(50) NOT NULL, user_id INT NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE books');
        $this->addSql('DROP TABLE libraries');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_book');
        $this->addSql('DROP TABLE user_password');
    }
}
