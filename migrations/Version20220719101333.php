<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220719101333 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bag DROP FOREIGN KEY FK_1B226841AA60395A');
        $this->addSql('DROP INDEX UNIQ_1B226841AA60395A ON bag');
        $this->addSql('ALTER TABLE bag DROP ordered_id');
        $this->addSql('ALTER TABLE contain ADD unit_price DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE ordered ADD bag_id INT NOT NULL');
        $this->addSql('ALTER TABLE ordered ADD CONSTRAINT FK_C3121F996F5D8297 FOREIGN KEY (bag_id) REFERENCES bag (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C3121F996F5D8297 ON ordered (bag_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bag ADD ordered_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE bag ADD CONSTRAINT FK_1B226841AA60395A FOREIGN KEY (ordered_id) REFERENCES ordered (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1B226841AA60395A ON bag (ordered_id)');
        $this->addSql('ALTER TABLE contain DROP unit_price');
        $this->addSql('ALTER TABLE ordered DROP FOREIGN KEY FK_C3121F996F5D8297');
        $this->addSql('DROP INDEX UNIQ_C3121F996F5D8297 ON ordered');
        $this->addSql('ALTER TABLE ordered DROP bag_id');
    }
}
