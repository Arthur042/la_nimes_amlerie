<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220727131638 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE adress CHANGE line1 line1 VARCHAR(100) NOT NULL, CHANGE line2 line2 VARCHAR(100) DEFAULT NULL, CHANGE line3 line3 VARCHAR(100) DEFAULT NULL, CHANGE city city VARCHAR(100) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE adress CHANGE line1 line1 VARCHAR(50) NOT NULL, CHANGE line2 line2 VARCHAR(50) DEFAULT NULL, CHANGE line3 line3 VARCHAR(50) DEFAULT NULL, CHANGE city city VARCHAR(50) NOT NULL');
    }
}
