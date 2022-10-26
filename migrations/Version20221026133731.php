<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221026133731 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE features_list (id INT AUTO_INCREMENT NOT NULL, structure_id INT DEFAULT NULL, add_new_members TINYINT(1) NOT NULL, send_newsletters TINYINT(1) NOT NULL, planning_manager TINYINT(1) NOT NULL, sell_drinks TINYINT(1) NOT NULL, sell_equipment TINYINT(1) NOT NULL, premium_plans TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_A0DD47472534008B (structure_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE franchisee (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(60) NOT NULL, director_firstname VARCHAR(20) NOT NULL, director_lastname VARCHAR(20) NOT NULL, email VARCHAR(254) NOT NULL, active TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE structure (id INT AUTO_INCREMENT NOT NULL, managed_by_id INT NOT NULL, name VARCHAR(60) NOT NULL, adress VARCHAR(100) NOT NULL, city VARCHAR(45) NOT NULL, manager_firstname VARCHAR(20) NOT NULL, manager_lastname VARCHAR(20) NOT NULL, manager_email VARCHAR(254) NOT NULL, active TINYINT(1) NOT NULL, INDEX IDX_6F0137EA873649CA (managed_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, franchisee_account_id INT DEFAULT NULL, structure_account_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, new_account TINYINT(1) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), UNIQUE INDEX UNIQ_8D93D6496B71F346 (franchisee_account_id), UNIQUE INDEX UNIQ_8D93D649A9256BF4 (structure_account_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE features_list ADD CONSTRAINT FK_A0DD47472534008B FOREIGN KEY (structure_id) REFERENCES structure (id)');
        $this->addSql('ALTER TABLE structure ADD CONSTRAINT FK_6F0137EA873649CA FOREIGN KEY (managed_by_id) REFERENCES franchisee (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6496B71F346 FOREIGN KEY (franchisee_account_id) REFERENCES franchisee (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649A9256BF4 FOREIGN KEY (structure_account_id) REFERENCES structure (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE features_list DROP FOREIGN KEY FK_A0DD47472534008B');
        $this->addSql('ALTER TABLE structure DROP FOREIGN KEY FK_6F0137EA873649CA');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6496B71F346');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649A9256BF4');
        $this->addSql('DROP TABLE features_list');
        $this->addSql('DROP TABLE franchisee');
        $this->addSql('DROP TABLE structure');
        $this->addSql('DROP TABLE user');
    }
}
