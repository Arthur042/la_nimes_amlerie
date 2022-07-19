<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220719094115 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE product_bag (product_id INT NOT NULL, bag_id INT NOT NULL, INDEX IDX_FB0D3C5E4584665A (product_id), INDEX IDX_FB0D3C5E6F5D8297 (bag_id), PRIMARY KEY(product_id, bag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_product (user_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_8B471AA7A76ED395 (user_id), INDEX IDX_8B471AA74584665A (product_id), PRIMARY KEY(user_id, product_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE product_bag ADD CONSTRAINT FK_FB0D3C5E4584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_bag ADD CONSTRAINT FK_FB0D3C5E6F5D8297 FOREIGN KEY (bag_id) REFERENCES bag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_product ADD CONSTRAINT FK_8B471AA7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_product ADD CONSTRAINT FK_8B471AA74584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bag ADD user_id INT NOT NULL, ADD ordered_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE bag ADD CONSTRAINT FK_1B226841A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE bag ADD CONSTRAINT FK_1B226841AA60395A FOREIGN KEY (ordered_id) REFERENCES ordered (id)');
        $this->addSql('CREATE INDEX IDX_1B226841A76ED395 ON bag (user_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1B226841AA60395A ON bag (ordered_id)');
        $this->addSql('ALTER TABLE category ADD sub_category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C1F7BFE87C FOREIGN KEY (sub_category_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_64C19C1F7BFE87C ON category (sub_category_id)');
        $this->addSql('ALTER TABLE ordered ADD status_id INT NOT NULL, ADD payment_id INT NOT NULL, ADD billing_adress_id INT NOT NULL');
        $this->addSql('ALTER TABLE ordered ADD CONSTRAINT FK_C3121F996BF700BD FOREIGN KEY (status_id) REFERENCES status (id)');
        $this->addSql('ALTER TABLE ordered ADD CONSTRAINT FK_C3121F994C3A3BB FOREIGN KEY (payment_id) REFERENCES payment (id)');
        $this->addSql('ALTER TABLE ordered ADD CONSTRAINT FK_C3121F9930959BF2 FOREIGN KEY (billing_adress_id) REFERENCES adress (id)');
        $this->addSql('CREATE INDEX IDX_C3121F996BF700BD ON ordered (status_id)');
        $this->addSql('CREATE INDEX IDX_C3121F994C3A3BB ON ordered (payment_id)');
        $this->addSql('CREATE INDEX IDX_C3121F9930959BF2 ON ordered (billing_adress_id)');
        $this->addSql('ALTER TABLE photo ADD product_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE photo ADD CONSTRAINT FK_14B784184584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('CREATE INDEX IDX_14B784184584665A ON photo (product_id)');
        $this->addSql('ALTER TABLE product ADD category_id INT NOT NULL, ADD mark_id INT NOT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD4290F12B FOREIGN KEY (mark_id) REFERENCES mark (id)');
        $this->addSql('CREATE INDEX IDX_D34A04AD12469DE2 ON product (category_id)');
        $this->addSql('CREATE INDEX IDX_D34A04AD4290F12B ON product (mark_id)');
        $this->addSql('ALTER TABLE user ADD gender_id INT NOT NULL, ADD adress_id INT NOT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649708A0E0 FOREIGN KEY (gender_id) REFERENCES gender (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6498486F9AC FOREIGN KEY (adress_id) REFERENCES adress (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649708A0E0 ON user (gender_id)');
        $this->addSql('CREATE INDEX IDX_8D93D6498486F9AC ON user (adress_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE product_bag');
        $this->addSql('DROP TABLE user_product');
        $this->addSql('ALTER TABLE bag DROP FOREIGN KEY FK_1B226841A76ED395');
        $this->addSql('ALTER TABLE bag DROP FOREIGN KEY FK_1B226841AA60395A');
        $this->addSql('DROP INDEX IDX_1B226841A76ED395 ON bag');
        $this->addSql('DROP INDEX UNIQ_1B226841AA60395A ON bag');
        $this->addSql('ALTER TABLE bag DROP user_id, DROP ordered_id');
        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C1F7BFE87C');
        $this->addSql('DROP INDEX IDX_64C19C1F7BFE87C ON category');
        $this->addSql('ALTER TABLE category DROP sub_category_id');
        $this->addSql('ALTER TABLE ordered DROP FOREIGN KEY FK_C3121F996BF700BD');
        $this->addSql('ALTER TABLE ordered DROP FOREIGN KEY FK_C3121F994C3A3BB');
        $this->addSql('ALTER TABLE ordered DROP FOREIGN KEY FK_C3121F9930959BF2');
        $this->addSql('DROP INDEX IDX_C3121F996BF700BD ON ordered');
        $this->addSql('DROP INDEX IDX_C3121F994C3A3BB ON ordered');
        $this->addSql('DROP INDEX IDX_C3121F9930959BF2 ON ordered');
        $this->addSql('ALTER TABLE ordered DROP status_id, DROP payment_id, DROP billing_adress_id');
        $this->addSql('ALTER TABLE photo DROP FOREIGN KEY FK_14B784184584665A');
        $this->addSql('DROP INDEX IDX_14B784184584665A ON photo');
        $this->addSql('ALTER TABLE photo DROP product_id');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD12469DE2');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD4290F12B');
        $this->addSql('DROP INDEX IDX_D34A04AD12469DE2 ON product');
        $this->addSql('DROP INDEX IDX_D34A04AD4290F12B ON product');
        $this->addSql('ALTER TABLE product DROP category_id, DROP mark_id');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649708A0E0');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6498486F9AC');
        $this->addSql('DROP INDEX IDX_8D93D649708A0E0 ON user');
        $this->addSql('DROP INDEX IDX_8D93D6498486F9AC ON user');
        $this->addSql('ALTER TABLE user DROP gender_id, DROP adress_id');
    }
}
