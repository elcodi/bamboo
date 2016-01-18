<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160118162657 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE pack (id INT AUTO_INCREMENT NOT NULL, manufacturer_id INT DEFAULT NULL, principal_category_id INT DEFAULT NULL, principal_image_id INT DEFAULT NULL, price_currency_iso VARCHAR(3) DEFAULT NULL, reduced_price_currency_iso VARCHAR(3) DEFAULT NULL, name VARCHAR(255) NOT NULL, sku VARCHAR(255) DEFAULT NULL, slug VARCHAR(255) NOT NULL, short_description VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, show_in_home TINYINT(1) NOT NULL, dimensions VARCHAR(255) DEFAULT NULL, stock INT DEFAULT NULL, stock_type INT NOT NULL, price INT DEFAULT NULL, reduced_price INT DEFAULT NULL, height INT NOT NULL, width INT NOT NULL, depth INT NOT NULL, weight INT NOT NULL, images_sort VARCHAR(2048) DEFAULT NULL, meta_title VARCHAR(255) DEFAULT NULL, meta_description VARCHAR(255) DEFAULT NULL, meta_keywords VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, enabled TINYINT(1) NOT NULL, INDEX IDX_97DE5E23A23B42D (manufacturer_id), INDEX IDX_97DE5E235740FE34 (principal_category_id), INDEX IDX_97DE5E23A7F1F96B (principal_image_id), INDEX IDX_97DE5E2347018B47 (price_currency_iso), INDEX IDX_97DE5E23EB35D9BE (reduced_price_currency_iso), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pack_category (pack_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_28C35DD01919B217 (pack_id), INDEX IDX_28C35DD012469DE2 (category_id), PRIMARY KEY(pack_id, category_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pack_image (pack_id INT NOT NULL, image_id INT NOT NULL, INDEX IDX_77C98E2E1919B217 (pack_id), INDEX IDX_77C98E2E3DA5256D (image_id), PRIMARY KEY(pack_id, image_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pack_product (pack_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_E80394D01919B217 (pack_id), INDEX IDX_E80394D04584665A (product_id), PRIMARY KEY(pack_id, product_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pack_variants (pack_id INT NOT NULL, variant_id INT NOT NULL, INDEX IDX_9D1717F01919B217 (pack_id), INDEX IDX_9D1717F03B69A9AF (variant_id), PRIMARY KEY(pack_id, variant_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE pack ADD CONSTRAINT FK_97DE5E23A23B42D FOREIGN KEY (manufacturer_id) REFERENCES manufacturer (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE pack ADD CONSTRAINT FK_97DE5E235740FE34 FOREIGN KEY (principal_category_id) REFERENCES category (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE pack ADD CONSTRAINT FK_97DE5E23A7F1F96B FOREIGN KEY (principal_image_id) REFERENCES image (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE pack ADD CONSTRAINT FK_97DE5E2347018B47 FOREIGN KEY (price_currency_iso) REFERENCES currency (iso)');
        $this->addSql('ALTER TABLE pack ADD CONSTRAINT FK_97DE5E23EB35D9BE FOREIGN KEY (reduced_price_currency_iso) REFERENCES currency (iso)');
        $this->addSql('ALTER TABLE pack_category ADD CONSTRAINT FK_28C35DD01919B217 FOREIGN KEY (pack_id) REFERENCES pack (id)');
        $this->addSql('ALTER TABLE pack_category ADD CONSTRAINT FK_28C35DD012469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE pack_image ADD CONSTRAINT FK_77C98E2E1919B217 FOREIGN KEY (pack_id) REFERENCES pack (id)');
        $this->addSql('ALTER TABLE pack_image ADD CONSTRAINT FK_77C98E2E3DA5256D FOREIGN KEY (image_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE pack_product ADD CONSTRAINT FK_E80394D01919B217 FOREIGN KEY (pack_id) REFERENCES pack (id)');
        $this->addSql('ALTER TABLE pack_product ADD CONSTRAINT FK_E80394D04584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE pack_variants ADD CONSTRAINT FK_9D1717F01919B217 FOREIGN KEY (pack_id) REFERENCES pack (id)');
        $this->addSql('ALTER TABLE pack_variants ADD CONSTRAINT FK_9D1717F03B69A9AF FOREIGN KEY (variant_id) REFERENCES variant (id)');
        $this->addSql('ALTER TABLE cart DROP quantity');
        $this->addSql('ALTER TABLE cart_line ADD pack_id INT DEFAULT NULL, CHANGE product_id product_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cart_line ADD CONSTRAINT FK_3EF1B4CF1919B217 FOREIGN KEY (pack_id) REFERENCES pack (id)');
        $this->addSql('CREATE INDEX IDX_3EF1B4CF1919B217 ON cart_line (pack_id)');
        $this->addSql('ALTER TABLE order_line ADD pack_id INT DEFAULT NULL, CHANGE product_id product_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE order_line ADD CONSTRAINT FK_9CE58EE11919B217 FOREIGN KEY (pack_id) REFERENCES pack (id)');
        $this->addSql('CREATE INDEX IDX_9CE58EE11919B217 ON order_line (pack_id)');
        $this->addSql('ALTER TABLE product CHANGE show_in_home show_in_home TINYINT(1) NOT NULL, CHANGE images_sort images_sort VARCHAR(2048) DEFAULT NULL');
        $this->addSql('ALTER TABLE variant CHANGE images_sort images_sort VARCHAR(2048) DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE cart_line DROP FOREIGN KEY FK_3EF1B4CF1919B217');
        $this->addSql('ALTER TABLE order_line DROP FOREIGN KEY FK_9CE58EE11919B217');
        $this->addSql('ALTER TABLE pack_category DROP FOREIGN KEY FK_28C35DD01919B217');
        $this->addSql('ALTER TABLE pack_image DROP FOREIGN KEY FK_77C98E2E1919B217');
        $this->addSql('ALTER TABLE pack_product DROP FOREIGN KEY FK_E80394D01919B217');
        $this->addSql('ALTER TABLE pack_variants DROP FOREIGN KEY FK_9D1717F01919B217');
        $this->addSql('DROP TABLE pack');
        $this->addSql('DROP TABLE pack_category');
        $this->addSql('DROP TABLE pack_image');
        $this->addSql('DROP TABLE pack_product');
        $this->addSql('DROP TABLE pack_variants');
        $this->addSql('ALTER TABLE cart ADD quantity INT NOT NULL');
        $this->addSql('DROP INDEX IDX_3EF1B4CF1919B217 ON cart_line');
        $this->addSql('ALTER TABLE cart_line DROP pack_id, CHANGE product_id product_id INT NOT NULL');
        $this->addSql('DROP INDEX IDX_9CE58EE11919B217 ON order_line');
        $this->addSql('ALTER TABLE order_line DROP pack_id, CHANGE product_id product_id INT NOT NULL');
        $this->addSql('ALTER TABLE product CHANGE show_in_home show_in_home TINYINT(1) DEFAULT NULL, CHANGE images_sort images_sort VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE variant CHANGE images_sort images_sort VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci');
    }
}
