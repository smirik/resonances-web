<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190327092051 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE two_body_libration_matrices (id INT AUTO_INCREMENT NOT NULL, planet1 VARCHAR(15) DEFAULT NULL, m1 INT NOT NULL, m INT NOT NULL, p1 INT NOT NULL, p INT NOT NULL, semi_axis DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE three_body_libration_matrices (id INT AUTO_INCREMENT NOT NULL, planet1 VARCHAR(15) DEFAULT NULL, planet2 VARCHAR(15) DEFAULT NULL, m1 INT NOT NULL, m2 INT NOT NULL, m INT NOT NULL, p1 INT NOT NULL, p2 INT NOT NULL, p INT NOT NULL, semi_axis DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE neo CHANGE asteroid_name asteroid_name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE asteroids CHANGE number number VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE asteroid_variation CHANGE asteroid_number asteroid_number VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE synthetic_proper_elements CHANGE number number INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE proper_elements CHANGE number number INT AUTO_INCREMENT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE two_body_libration_matrices');
        $this->addSql('DROP TABLE three_body_libration_matrices');
        $this->addSql('ALTER TABLE asteroid_variation CHANGE asteroid_number asteroid_number VARCHAR(255) NOT NULL COLLATE utf8_general_ci');
        $this->addSql('ALTER TABLE asteroids CHANGE number number VARCHAR(255) NOT NULL COLLATE utf8_general_ci');
        $this->addSql('ALTER TABLE neo CHANGE asteroid_name asteroid_name VARCHAR(255) NOT NULL COLLATE utf8_general_ci');
        $this->addSql('ALTER TABLE proper_elements CHANGE number number INT NOT NULL');
        $this->addSql('ALTER TABLE synthetic_proper_elements CHANGE number number INT DEFAULT 0 NOT NULL');
    }
}
