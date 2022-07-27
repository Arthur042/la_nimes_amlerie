<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220727124336 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contain CHANGE unit_price unit_price NUMERIC(6, 2) NOT NULL');
        $this->addSql('ALTER TABLE product CHANGE price_ht price_ht NUMERIC(6, 2) NOT NULL, CHANGE tva tva NUMERIC(3, 2) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contain CHANGE unit_price unit_price DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE product CHANGE price_ht price_ht DOUBLE PRECISION NOT NULL, CHANGE tva tva DOUBLE PRECISION NOT NULL');
    }
}
