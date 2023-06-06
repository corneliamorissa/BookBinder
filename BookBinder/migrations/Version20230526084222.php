<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230526084222 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        //$this->addSql('CREATE TABLE user_password (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(50) NOT NULL, user_id INT NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE avatar (id INT AUTO_INCREMENT NOT NULL PRIMARY KEY , image MEDIUMBLOB NOT NULL )');
        $this->addSql('CREATE TABLE review (id INT AUTO_INCREMENT NOT NULL PRIMARY KEY , text TEXT, author VARCHAR(40), rate INT, book TEXT )');
        $this->addSql('CREATE TABLE meetup (id INT AUTO_INCREMENT NOT NULL PRIMARY KEY , id_user_inviter INT, id_user_invited INT, date_time DATETIME, accepted TINYINT, declined TINYINT, id_library INT )');
        //$this->addSql('ALTER TABLE avatar CHANGE image image LONGBLOB NOT NULL');
        //$this->addSql('ALTER TABLE books DROP FOREIGN KEY FK_library');
        //$this->addSql('DROP INDEX FK_libraries_idx ON books');
        //$this->addSql('ALTER TABLE books CHANGE title title VARCHAR(255) NOT NULL, CHANGE number_of_pages number_of_pages INT NOT NULL, CHANGE author author VARCHAR(255) NOT NULL, CHANGE isbn isbn VARCHAR(255) NOT NULL, CHANGE rating rating NUMERIC(3, 1) NOT NULL, CHANGE number_of_votes number_of_votes INT NOT NULL');
        //$this->addSql('DROP INDEX LibraryID_UNIQUE ON libraries');
        $this->addSql('ALTER TABLE libraries CHANGE name name VARCHAR(255) NOT NULL, CHANGE street street VARCHAR(255) NOT NULL, CHANGE housenumber housenumber INT NOT NULL');
        $this->addSql('ALTER TABLE meetup CHANGE id_user_inviter id_user_inviter INT NOT NULL, CHANGE id_user_invited id_user_invited INT NOT NULL, CHANGE date_time date_time DATETIME NOT NULL, CHANGE accepted accepted INT DEFAULT NULL, CHANGE declined declined INT DEFAULT NULL, CHANGE id_library id_library INT NOT NULL');
        $this->addSql('ALTER TABLE review CHANGE text text LONGTEXT DEFAULT NULL, CHANGE book book LONGTEXT DEFAULT NULL');
        //$this->addSql('ALTER TABLE user DROP FOREIGN KEY avatar_id');
        //$this->addSql('DROP INDEX avatar_id_idx ON user');
        //$this->addSql('DROP INDEX Username ON user');
        $this->addSql('ALTER TABLE user CHANGE username username VARCHAR(50) NOT NULL, CHANGE first_name first_name VARCHAR(50) NOT NULL, CHANGE last_name last_name VARCHAR(50) NOT NULL, CHANGE street street VARCHAR(100) NOT NULL, CHANGE house_number house_number INT NOT NULL, CHANGE postcode postcode INT NOT NULL, CHANGE birthdate birthdate DATE NOT NULL, CHANGE private_account private_account INT DEFAULT 0 NOT NULL, CHANGE password password VARCHAR(256) NOT NULL, CHANGE roles roles JSON NOT NULL');
        //$this->addSql('ALTER TABLE user_book DROP FOREIGN KEY user_book_ibfk_2');
        //$this->addSql('ALTER TABLE user_book DROP FOREIGN KEY user_id_fk');
        //$this->addSql('DROP INDEX BookID ON user_book');
        //$this->addSql('DROP INDEX user_id_fk_idx ON user_book');
        $this->addSql('ALTER TABLE user_book CHANGE userid userid INT NOT NULL, CHANGE bookid bookid INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE user_password');
        $this->addSql('ALTER TABLE meetup CHANGE id_user_inviter id_user_inviter INT DEFAULT NULL, CHANGE id_user_invited id_user_invited INT DEFAULT NULL, CHANGE date_time date_time DATETIME DEFAULT CURRENT_TIMESTAMP, CHANGE accepted accepted TINYINT(1) DEFAULT 0, CHANGE declined declined TINYINT(1) DEFAULT 0, CHANGE id_library id_library INT DEFAULT NULL');
        $this->addSql('ALTER TABLE books CHANGE title title VARCHAR(254) NOT NULL, CHANGE number_of_pages number_of_pages VARCHAR(45) NOT NULL, CHANGE author author VARCHAR(750) NOT NULL, CHANGE isbn isbn VARCHAR(45) NOT NULL, CHANGE rating rating NUMERIC(3, 1) DEFAULT NULL, CHANGE number_of_votes number_of_votes INT DEFAULT NULL');
        $this->addSql('ALTER TABLE books ADD CONSTRAINT FK_library FOREIGN KEY (library) REFERENCES libraries (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX FK_libraries_idx ON books (library)');
        $this->addSql('ALTER TABLE review CHANGE text text TEXT DEFAULT NULL, CHANGE book book TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE avatar CHANGE image image MEDIUMBLOB DEFAULT NULL');
        $this->addSql('ALTER TABLE user_book CHANGE bookid bookid INT DEFAULT NULL, CHANGE userid userid INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user_book ADD CONSTRAINT user_book_ibfk_2 FOREIGN KEY (bookid) REFERENCES books (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE user_book ADD CONSTRAINT user_id_fk FOREIGN KEY (userid) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX BookID ON user_book (bookid)');
        $this->addSql('CREATE INDEX user_id_fk_idx ON user_book (userid)');
        $this->addSql('ALTER TABLE libraries CHANGE name name VARCHAR(45) DEFAULT NULL, CHANGE street street VARCHAR(45) DEFAULT NULL, CHANGE housenumber housenumber VARCHAR(45) DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX LibraryID_UNIQUE ON libraries (id)');
        $this->addSql('ALTER TABLE user CHANGE username username VARCHAR(50) DEFAULT NULL, CHANGE first_name first_name VARCHAR(50) DEFAULT NULL, CHANGE last_name last_name VARCHAR(50) DEFAULT NULL, CHANGE street street VARCHAR(100) DEFAULT NULL, CHANGE house_number house_number VARCHAR(10) DEFAULT NULL, CHANGE postcode postcode VARCHAR(10) DEFAULT NULL, CHANGE birthdate birthdate DATE DEFAULT NULL, CHANGE private_account private_account TINYINT(1) DEFAULT 0 NOT NULL, CHANGE roles roles JSON DEFAULT NULL, CHANGE password password VARCHAR(256) DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT avatar_id FOREIGN KEY (avatar_id) REFERENCES avatar (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX avatar_id_idx ON user (avatar_id)');
        $this->addSql('CREATE UNIQUE INDEX Username ON user (username)');
    }
}
