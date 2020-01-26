<?php

declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200126112336 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE fos_user');
        $this->addSql('DROP TABLE user_admin');
        $this->addSql('DROP TABLE user_admine');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE fos_user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, username_canonical VARCHAR(180) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, email VARCHAR(180) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, email_canonical VARCHAR(180) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, enabled TINYINT(1) NOT NULL, salt VARCHAR(255) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, password VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, last_login DATETIME DEFAULT NULL, confirmation_token VARCHAR(180) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, password_requested_at DATETIME DEFAULT NULL, roles LONGTEXT CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci` COMMENT \'(DC2Type:array)\', telephone VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, nom VARCHAR(30) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, prenom VARCHAR(30) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, etat TINYINT(1) DEFAULT \'0\' NOT NULL, diplome VARCHAR(30) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, date_entree DATETIME NOT NULL, date_sortie DATETIME NOT NULL, etudiant INT NOT NULL, cliqueOffre INT NOT NULL, cliqueActualite INT NOT NULL, cliqueSandage INT NOT NULL, acceptmail INT NOT NULL, accepttelephone INT NOT NULL, DateOffre DATETIME NOT NULL, DateSandage DATETIME NOT NULL, DateActualite DATETIME NOT NULL, UNIQUE INDEX UNIQ_957A6479C05FB297 (confirmation_token), UNIQUE INDEX UNIQ_957A647992FC23A8 (username_canonical), UNIQUE INDEX UNIQ_957A6479A0D96FBF (email_canonical), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE user_admin (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, username_canonical VARCHAR(180) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, email VARCHAR(180) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, email_canonical VARCHAR(180) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, enabled TINYINT(1) NOT NULL, salt VARCHAR(255) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, password VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, last_login DATETIME DEFAULT NULL, confirmation_token VARCHAR(180) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, password_requested_at DATETIME DEFAULT NULL, roles LONGTEXT CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci` COMMENT \'(DC2Type:array)\', telephone VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, nom VARCHAR(30) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, prenom VARCHAR(30) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, etat TINYINT(1) DEFAULT \'0\' NOT NULL, diplome VARCHAR(30) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, date_entree DATETIME NOT NULL, date_sortie DATETIME NOT NULL, etudiant INT NOT NULL, cliqueOffre INT NOT NULL, cliqueActualite INT NOT NULL, cliqueSandage INT NOT NULL, acceptmail INT NOT NULL, accepttelephone INT NOT NULL, DateOffre DATETIME NOT NULL, DateSandage DATETIME NOT NULL, DateActualite DATETIME NOT NULL, UNIQUE INDEX UNIQ_6ACCF62EC05FB297 (confirmation_token), UNIQUE INDEX UNIQ_6ACCF62E92FC23A8 (username_canonical), UNIQUE INDEX UNIQ_6ACCF62EA0D96FBF (email_canonical), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE user_admine (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, username_canonical VARCHAR(180) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, email VARCHAR(180) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, email_canonical VARCHAR(180) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, enabled TINYINT(1) NOT NULL, salt VARCHAR(255) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, password VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, last_login DATETIME DEFAULT NULL, confirmation_token VARCHAR(180) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, password_requested_at DATETIME DEFAULT NULL, roles LONGTEXT CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci` COMMENT \'(DC2Type:array)\', telephone VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, nom VARCHAR(30) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, prenom VARCHAR(30) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, etat TINYINT(1) DEFAULT \'0\' NOT NULL, diplome VARCHAR(30) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, date_entree DATETIME NOT NULL, date_sortie DATETIME NOT NULL, etudiant INT NOT NULL, cliqueOffre INT NOT NULL, cliqueActualite INT NOT NULL, cliqueSandage INT NOT NULL, acceptmail INT NOT NULL, accepttelephone INT NOT NULL, DateOffre DATETIME NOT NULL, DateSandage DATETIME NOT NULL, DateActualite DATETIME NOT NULL, UNIQUE INDEX UNIQ_3366BB63C05FB297 (confirmation_token), UNIQUE INDEX UNIQ_3366BB6392FC23A8 (username_canonical), UNIQUE INDEX UNIQ_3366BB63A0D96FBF (email_canonical), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
    }
}
