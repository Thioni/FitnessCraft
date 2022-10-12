<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221012135214 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE features_list (id INT AUTO_INCREMENT NOT NULL, structure_id INT DEFAULT NULL, add_new_members TINYINT(1) NOT NULL, send_newsletters TINYINT(1) NOT NULL, planning_manager TINYINT(1) NOT NULL, sell_drinks TINYINT(1) NOT NULL, sell_equipment TINYINT(1) NOT NULL, premium_plans TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_A0DD47472534008B (structure_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE features_list ADD CONSTRAINT FK_A0DD47472534008B FOREIGN KEY (structure_id) REFERENCES structure (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE features_list DROP FOREIGN KEY FK_A0DD47472534008B');
        $this->addSql('DROP TABLE features_list');
    }
}
