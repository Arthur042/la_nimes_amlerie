<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220826085451 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ordered DROP FOREIGN KEY FK_C3121F996F5D8297');
        $this->addSql('ALTER TABLE ordered ADD CONSTRAINT FK_C3121F996F5D8297 FOREIGN KEY (bag_id) REFERENCES bag (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ordered DROP FOREIGN KEY FK_C3121F996F5D8297');
        $this->addSql('ALTER TABLE ordered ADD CONSTRAINT FK_C3121F996F5D8297 FOREIGN KEY (bag_id) REFERENCES bag (id)');
    }
}
