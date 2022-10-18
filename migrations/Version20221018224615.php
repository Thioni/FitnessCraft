<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221018224615 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE franchisee ADD director_firstname VARCHAR(20) NOT NULL, ADD director_lastname VARCHAR(20) NOT NULL');
        $this->addSql('ALTER TABLE structure ADD ville VARCHAR(45) NOT NULL, ADD manager_firstname VARCHAR(20) NOT NULL, ADD manager_lastname VARCHAR(20) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE franchisee DROP director_firstname, DROP director_lastname');
        $this->addSql('ALTER TABLE structure DROP ville, DROP manager_firstname, DROP manager_lastname');
    }
}
