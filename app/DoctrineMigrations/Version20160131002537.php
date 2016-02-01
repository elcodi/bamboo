<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2016 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Feel free to edit as you please, and have fun.
 *
 * @author Marc Morera <yuhu@mmoreram.com>
 * @author Aldo Chiecchia <zimage@tiscali.it>
 * @author Elcodi Team <tech@elcodi.com>
 */

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160131002537 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE cart (id INT AUTO_INCREMENT NOT NULL, customer_id INT DEFAULT NULL, delivery_address_id INT DEFAULT NULL, billing_address_id INT DEFAULT NULL, ordered TINYINT(1) NOT NULL, shipping_method VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_BA388B79395C3F3 (customer_id), INDEX IDX_BA388B7EBF23851 (delivery_address_id), INDEX IDX_BA388B779D0C0E4 (billing_address_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cart_line (id INT AUTO_INCREMENT NOT NULL, order_line_id INT DEFAULT NULL, cart_id INT NOT NULL, purchasable_currency_iso VARCHAR(3) NOT NULL, currency_iso VARCHAR(3) NOT NULL, purchasable_id INT DEFAULT NULL, purchasable_amount INT NOT NULL, amount INT NOT NULL, quantity INT NOT NULL, UNIQUE INDEX UNIQ_3EF1B4CFBB01DC09 (order_line_id), INDEX IDX_3EF1B4CF1AD5CDBF (cart_id), INDEX IDX_3EF1B4CFCA263E04 (purchasable_currency_iso), INDEX IDX_3EF1B4CFB3D2E75A (currency_iso), INDEX IDX_3EF1B4CF9778C508 (purchasable_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE orders (id INT AUTO_INCREMENT NOT NULL, cart_id INT DEFAULT NULL, payment_last_state_line_id INT NOT NULL, shipping_last_state_line_id INT NOT NULL, customer_id INT DEFAULT NULL, currency_iso VARCHAR(3) NOT NULL, purchasable_currency_iso VARCHAR(3) NOT NULL, coupon_currency_iso VARCHAR(3) DEFAULT NULL, shipping_currency_iso VARCHAR(3) DEFAULT NULL, delivery_address_id INT DEFAULT NULL, billing_address_id INT DEFAULT NULL, quantity INT NOT NULL, purchasable_amount INT NOT NULL, coupon_amount INT DEFAULT NULL, shipping_amount INT DEFAULT NULL, shipping_method LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', shipping_method_extra LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', payment_method LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', payment_method_extra LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', amount INT NOT NULL, height INT NOT NULL, width INT NOT NULL, depth INT NOT NULL, weight INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_E52FFDEE1AD5CDBF (cart_id), UNIQUE INDEX UNIQ_E52FFDEEAD8238BF (payment_last_state_line_id), UNIQUE INDEX UNIQ_E52FFDEE5B8FCE3F (shipping_last_state_line_id), INDEX IDX_E52FFDEE9395C3F3 (customer_id), INDEX IDX_E52FFDEEB3D2E75A (currency_iso), INDEX IDX_E52FFDEECA263E04 (purchasable_currency_iso), INDEX IDX_E52FFDEEFB17B782 (coupon_currency_iso), INDEX IDX_E52FFDEEFC817E8F (shipping_currency_iso), INDEX IDX_E52FFDEEEBF23851 (delivery_address_id), INDEX IDX_E52FFDEE79D0C0E4 (billing_address_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shipping_state_lines (order_id INT NOT NULL, state_line_id INT NOT NULL, INDEX IDX_B1F98F398D9F6D38 (order_id), INDEX IDX_B1F98F39B1B0FE4 (state_line_id), PRIMARY KEY(order_id, state_line_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE payment_state_lines (order_id INT NOT NULL, state_line_id INT NOT NULL, INDEX IDX_CB1ED8408D9F6D38 (order_id), INDEX IDX_CB1ED840B1B0FE4 (state_line_id), PRIMARY KEY(order_id, state_line_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE order_line (id INT AUTO_INCREMENT NOT NULL, order_id INT NOT NULL, purchasable_currency_iso VARCHAR(3) NOT NULL, currency_iso VARCHAR(3) NOT NULL, purchasable_id INT DEFAULT NULL, purchasable_amount NUMERIC(10, 2) NOT NULL, amount NUMERIC(10, 2) NOT NULL, height INT NOT NULL, width INT NOT NULL, depth INT NOT NULL, weight INT NOT NULL, quantity INT NOT NULL, INDEX IDX_9CE58EE18D9F6D38 (order_id), INDEX IDX_9CE58EE1CA263E04 (purchasable_currency_iso), INDEX IDX_9CE58EE1B3D2E75A (currency_iso), INDEX IDX_9CE58EE19778C508 (purchasable_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE coupon (id INT AUTO_INCREMENT NOT NULL, price_currency_iso VARCHAR(3) DEFAULT NULL, minimum_purchase_currency_iso VARCHAR(3) DEFAULT NULL, rule INT DEFAULT NULL, code VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, type INT NOT NULL, enforcement INT NOT NULL, price_amount INT NOT NULL, discount INT NOT NULL, value VARCHAR(255) DEFAULT NULL, count INT NOT NULL, used INT NOT NULL, priority INT NOT NULL, minimum_purchase_amount INT DEFAULT NULL, stackable TINYINT(1) DEFAULT \'0\' NOT NULL, valid_from DATETIME NOT NULL, valid_to DATETIME DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, enabled TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_64BF3F0277153098 (code), INDEX IDX_64BF3F0247018B47 (price_currency_iso), INDEX IDX_64BF3F02DCEAE720 (minimum_purchase_currency_iso), INDEX IDX_64BF3F0246D8ACCC (rule), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rule (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(64) NOT NULL, expression LONGTEXT NOT NULL, UNIQUE INDEX UNIQ_46D8ACCC5E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE currency (iso VARCHAR(3) NOT NULL, name VARCHAR(65) NOT NULL, symbol VARCHAR(15) NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, enabled TINYINT(1) NOT NULL, PRIMARY KEY(iso)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE currency_exchange_rate (id INT AUTO_INCREMENT NOT NULL, target_currency_iso VARCHAR(3) DEFAULT NULL, source_currency_iso VARCHAR(3) DEFAULT NULL, exchange_rate NUMERIC(18, 10) NOT NULL, INDEX IDX_B9F60EEC5380340B (target_currency_iso), INDEX IDX_B9F60EEC65383BE2 (source_currency_iso), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE language (iso VARCHAR(10) NOT NULL, name VARCHAR(255) NOT NULL, enabled TINYINT(1) NOT NULL, PRIMARY KEY(iso)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, content_type VARCHAR(255) NOT NULL, extension VARCHAR(10) NOT NULL, size INT NOT NULL, width INT NOT NULL, height INT NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, enabled TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE address (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, recipient_name VARCHAR(255) DEFAULT NULL, recipient_surname VARCHAR(255) DEFAULT NULL, city VARCHAR(64) NOT NULL, postal_code VARCHAR(64) NOT NULL, address VARCHAR(255) NOT NULL, address_more VARCHAR(255) DEFAULT NULL, phone VARCHAR(255) NOT NULL, mobile VARCHAR(255) DEFAULT NULL, comments LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, enabled TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE location (id VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, code VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE location_inheritance (parent_id VARCHAR(255) NOT NULL, children_id VARCHAR(255) NOT NULL, INDEX IDX_CD045D5727ACA70 (parent_id), INDEX IDX_CD045D53D3D2749 (children_id), PRIMARY KEY(parent_id, children_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE attribute (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, enabled TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE value (id INT AUTO_INCREMENT NOT NULL, attribute_id INT NOT NULL, value VARCHAR(255) NOT NULL, INDEX IDX_1D775834B6E62EFA (attribute_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE store (id INT AUTO_INCREMENT NOT NULL, logo_id INT DEFAULT NULL, secondary_logo_id INT DEFAULT NULL, mobile_logo_id INT DEFAULT NULL, header_image_id INT DEFAULT NULL, background_image_id INT DEFAULT NULL, address_id INT DEFAULT NULL, default_language_iso VARCHAR(10) DEFAULT NULL, default_currency_iso VARCHAR(3) DEFAULT NULL, name VARCHAR(255) NOT NULL, leitmotiv VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, is_company TINYINT(1) NOT NULL, cif VARCHAR(255) DEFAULT NULL, tracker VARCHAR(255) DEFAULT NULL, template VARCHAR(255) DEFAULT NULL, routing_strategy VARCHAR(255) NOT NULL, use_stock TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, enabled TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_FF575877F98F144A (logo_id), UNIQUE INDEX UNIQ_FF5758773C91E28A (secondary_logo_id), UNIQUE INDEX UNIQ_FF5758771925D9BF (mobile_logo_id), UNIQUE INDEX UNIQ_FF5758778C782417 (header_image_id), UNIQUE INDEX UNIQ_FF575877E6DA28AA (background_image_id), INDEX IDX_FF575877F5B7AF75 (address_id), INDEX IDX_FF575877920835C7 (default_language_iso), INDEX IDX_FF575877910402F0 (default_currency_iso), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE admin_user (id INT AUTO_INCREMENT NOT NULL, gender INT DEFAULT NULL, password VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, token VARCHAR(255) NOT NULL, firstname VARCHAR(255) DEFAULT NULL, lastname VARCHAR(255) DEFAULT NULL, birthday DATE DEFAULT NULL, recovery_hash VARCHAR(255) DEFAULT NULL, one_time_login_hash VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, last_login_at DATETIME DEFAULT NULL, enabled TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_AD8A54A95F37A13B (token), UNIQUE INDEX UNIQ_AD8A54A98A2057A4 (recovery_hash), UNIQUE INDEX UNIQ_AD8A54A98586CD6F (one_time_login_hash), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE customer (id INT AUTO_INCREMENT NOT NULL, delivery_address_id INT DEFAULT NULL, invoice_address_id INT DEFAULT NULL, language_iso VARCHAR(10) DEFAULT NULL, gender INT DEFAULT NULL, password VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, token VARCHAR(255) NOT NULL, firstname VARCHAR(255) DEFAULT NULL, lastname VARCHAR(255) DEFAULT NULL, birthday DATE DEFAULT NULL, recovery_hash VARCHAR(255) DEFAULT NULL, one_time_login_hash VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, last_login_at DATETIME DEFAULT NULL, enabled TINYINT(1) NOT NULL, phone VARCHAR(15) DEFAULT NULL, identity_document VARCHAR(255) DEFAULT NULL, guest TINYINT(1) NOT NULL, newsletter TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_81398E095F37A13B (token), UNIQUE INDEX UNIQ_81398E098A2057A4 (recovery_hash), UNIQUE INDEX UNIQ_81398E098586CD6F (one_time_login_hash), UNIQUE INDEX UNIQ_81398E09EBF23851 (delivery_address_id), UNIQUE INDEX UNIQ_81398E09C6BDFEB (invoice_address_id), INDEX IDX_81398E09B0DED06D (language_iso), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE customer_address (customer_id INT NOT NULL, address_id INT NOT NULL, INDEX IDX_1193CB3F9395C3F3 (customer_id), INDEX IDX_1193CB3FF5B7AF75 (address_id), PRIMARY KEY(customer_id, address_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE purchasable (id INT AUTO_INCREMENT NOT NULL, principal_category_id INT DEFAULT NULL, principal_image_id INT DEFAULT NULL, price_currency_iso VARCHAR(3) DEFAULT NULL, reduced_price_currency_iso VARCHAR(3) DEFAULT NULL, manufacturer_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, sku VARCHAR(255) DEFAULT NULL, slug VARCHAR(255) DEFAULT NULL, short_description VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, show_in_home TINYINT(1) DEFAULT NULL, dimensions VARCHAR(255) DEFAULT NULL, stock INT DEFAULT NULL, price INT DEFAULT NULL, reduced_price INT DEFAULT NULL, height INT DEFAULT NULL, width INT DEFAULT NULL, depth INT DEFAULT NULL, weight INT DEFAULT NULL, images_sort VARCHAR(2048) DEFAULT NULL, meta_title VARCHAR(255) DEFAULT NULL, meta_description VARCHAR(255) DEFAULT NULL, meta_keywords VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, enabled TINYINT(1) NOT NULL, purchasable_type VARCHAR(255) NOT NULL, INDEX IDX_FC2E9BFE5740FE34 (principal_category_id), INDEX IDX_FC2E9BFEA7F1F96B (principal_image_id), INDEX IDX_FC2E9BFE47018B47 (price_currency_iso), INDEX IDX_FC2E9BFEEB35D9BE (reduced_price_currency_iso), INDEX IDX_FC2E9BFEA23B42D (manufacturer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE purchasable_image (product_id INT NOT NULL, image_id INT NOT NULL, INDEX IDX_3A78D4124584665A (product_id), INDEX IDX_3A78D4123DA5256D (image_id), PRIMARY KEY(product_id, image_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE purchasable_category (purchasable_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_F98077AD9778C508 (purchasable_id), INDEX IDX_F98077AD12469DE2 (category_id), PRIMARY KEY(purchasable_id, category_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT NOT NULL, principal_variant_id INT DEFAULT NULL, INDEX IDX_D34A04ADE2560A82 (principal_variant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_attribute (product_id INT NOT NULL, attribute_id INT NOT NULL, INDEX IDX_94DA59764584665A (product_id), INDEX IDX_94DA5976B6E62EFA (attribute_id), PRIMARY KEY(product_id, attribute_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE variant (id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_F143BFAD4584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE variant_options (variant_id INT NOT NULL, option_id INT NOT NULL, INDEX IDX_BF90D7C13B69A9AF (variant_id), INDEX IDX_BF90D7C1A7C41D6F (option_id), PRIMARY KEY(variant_id, option_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pack (id INT NOT NULL, stock_type INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pack_purchasable (pack_id INT NOT NULL, purchasable_id INT NOT NULL, INDEX IDX_8D846271919B217 (pack_id), INDEX IDX_8D846279778C508 (purchasable_id), PRIMARY KEY(pack_id, purchasable_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, root TINYINT(1) NOT NULL, position INT NOT NULL, meta_title VARCHAR(255) DEFAULT NULL, meta_description VARCHAR(255) DEFAULT NULL, meta_keywords VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, enabled TINYINT(1) NOT NULL, INDEX IDX_64C19C1727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE manufacturer (id INT AUTO_INCREMENT NOT NULL, principal_image_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, images_sort VARCHAR(255) DEFAULT NULL, meta_title VARCHAR(255) DEFAULT NULL, meta_description VARCHAR(255) DEFAULT NULL, meta_keywords VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, enabled TINYINT(1) NOT NULL, INDEX IDX_3D0AE6DCA7F1F96B (principal_image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE manufacturer_image (product_id INT NOT NULL, image_id INT NOT NULL, INDEX IDX_CE63904F4584665A (product_id), INDEX IDX_CE63904F3DA5256D (image_id), PRIMARY KEY(product_id, image_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE state_line (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE zone (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, code VARCHAR(32) NOT NULL, locations VARCHAR(1024) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, enabled TINYINT(1) DEFAULT NULL, UNIQUE INDEX UNIQ_A0EBC00777153098 (code), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tax (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(15) NOT NULL, description VARCHAR(255) NOT NULL, value DOUBLE PRECISION NOT NULL, enabled TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE entity_translation (entity_type VARCHAR(255) NOT NULL, entity_id VARCHAR(255) NOT NULL, entity_field VARCHAR(255) NOT NULL, locale VARCHAR(8) NOT NULL, translation LONGTEXT NOT NULL, PRIMARY KEY(entity_type, entity_id, entity_field, locale)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menu (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, enabled TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menu_node_hierarchy (menu_node_id INT NOT NULL, menu_subnode_id INT NOT NULL, INDEX IDX_F80FD5E9CED68269 (menu_node_id), INDEX IDX_F80FD5E92CC283CA (menu_subnode_id), PRIMARY KEY(menu_node_id, menu_subnode_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menu_node (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, code VARCHAR(25) DEFAULT NULL, url VARCHAR(255) DEFAULT NULL, active_urls LONGTEXT NOT NULL, tag VARCHAR(255) DEFAULT NULL, priority INT NOT NULL, enabled TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE node_hierarchy (menu_node_id INT NOT NULL, menu_subnode_id INT NOT NULL, INDEX IDX_E1C520CDCED68269 (menu_node_id), INDEX IDX_E1C520CD2CC283CA (menu_subnode_id), PRIMARY KEY(menu_node_id, menu_subnode_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE plugin (namespace VARCHAR(255) NOT NULL, hash VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, category VARCHAR(255) DEFAULT NULL, enabled TINYINT(1) NOT NULL, plugin_configuration LONGTEXT NOT NULL COMMENT \'(DC2Type:json_array)\', UNIQUE INDEX UNIQ_E96E2794D1B862B8 (hash), PRIMARY KEY(namespace)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cart_coupon (id INT AUTO_INCREMENT NOT NULL, cart_id INT DEFAULT NULL, coupon_id INT DEFAULT NULL, INDEX IDX_6A3B5D5D1AD5CDBF (cart_id), INDEX IDX_6A3B5D5D66C5951B (coupon_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE order_coupon (id INT AUTO_INCREMENT NOT NULL, order_id INT DEFAULT NULL, coupon_id INT DEFAULT NULL, amount_currency_iso VARCHAR(3) DEFAULT NULL, amount INT NOT NULL, code VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_A7302FD78D9F6D38 (order_id), INDEX IDX_A7302FD766C5951B (coupon_id), INDEX IDX_A7302FD7D82D7CDD (amount_currency_iso), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE banner (id INT AUTO_INCREMENT NOT NULL, image_id INT DEFAULT NULL, principal_image_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, url VARCHAR(255) DEFAULT NULL, position INT DEFAULT NULL, enabled TINYINT(1) DEFAULT NULL, UNIQUE INDEX UNIQ_6F9DB8E73DA5256D (image_id), INDEX IDX_6F9DB8E7A7F1F96B (principal_image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE banner_banner_zone (banner_id INT NOT NULL, banner_zone_id INT NOT NULL, INDEX IDX_98251B1E684EC833 (banner_id), INDEX IDX_98251B1ECB711668 (banner_zone_id), PRIMARY KEY(banner_id, banner_zone_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE banner_zone (id INT AUTO_INCREMENT NOT NULL, language_iso VARCHAR(10) DEFAULT NULL, name VARCHAR(255) NOT NULL, code VARCHAR(255) NOT NULL, height INT NOT NULL, width INT NOT NULL, INDEX IDX_A852916DB0DED06D (language_iso), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE newsletter_subscription (id INT AUTO_INCREMENT NOT NULL, language_iso VARCHAR(10) DEFAULT NULL, email VARCHAR(255) NOT NULL, hash VARCHAR(255) NOT NULL, reason LONGTEXT DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, enabled TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_A82B55ADE7927C74 (email), UNIQUE INDEX UNIQ_A82B55ADD1B862B8 (hash), INDEX IDX_A82B55ADB0DED06D (language_iso), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE page (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, title VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, type INT NOT NULL, path VARCHAR(255) DEFAULT NULL, publication_date DATETIME DEFAULT NULL, persistent TINYINT(1) NOT NULL, meta_title VARCHAR(255) DEFAULT NULL, meta_description VARCHAR(255) DEFAULT NULL, meta_keywords VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, enabled TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_140AB6205E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE metric_entry (id INT AUTO_INCREMENT NOT NULL, token VARCHAR(255) NOT NULL, event VARCHAR(255) NOT NULL, value VARCHAR(512) DEFAULT NULL, type INT NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, source VARCHAR(255) NOT NULL, context VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, author_token VARCHAR(255) DEFAULT NULL, author_name VARCHAR(255) DEFAULT NULL, author_email VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, enabled TINYINT(1) NOT NULL, INDEX IDX_9474526C727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment_vote (author_token VARCHAR(255) NOT NULL, comment_id INT NOT NULL, type TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_7C262788F8697D13 (comment_id), PRIMARY KEY(author_token, comment_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE authorization (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, resourceowner_name VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, authorization_token VARCHAR(255) NOT NULL, expiration_date DATETIME NOT NULL, UNIQUE INDEX UNIQ_7A6D8BEFA76ED395 (user_id), INDEX resourceowner_username_idx (resourceowner_name, username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shipping_range (id INT AUTO_INCREMENT NOT NULL, carrier_id INT NOT NULL, from_zone_id INT DEFAULT NULL, to_zone_id INT NOT NULL, price_currency_iso VARCHAR(3) NOT NULL, from_price_currency_iso VARCHAR(3) NOT NULL, to_price_currency_iso VARCHAR(3) NOT NULL, type INT NOT NULL, name VARCHAR(255) NOT NULL, from_price_amount INT DEFAULT NULL, to_price_amount INT DEFAULT NULL, from_weight INT DEFAULT NULL, to_weight INT DEFAULT NULL, price_amount INT NOT NULL, enabled TINYINT(1) NOT NULL, INDEX IDX_7D1887F321DFC797 (carrier_id), INDEX IDX_7D1887F31972DC04 (from_zone_id), INDEX IDX_7D1887F311B4025E (to_zone_id), INDEX IDX_7D1887F347018B47 (price_currency_iso), INDEX IDX_7D1887F3D6956502 (from_price_currency_iso), INDEX IDX_7D1887F315643E2F (to_price_currency_iso), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE carrier (id INT AUTO_INCREMENT NOT NULL, tax_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, enabled TINYINT(1) NOT NULL, INDEX IDX_4739F11CB2A824D8 (tax_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cart ADD CONSTRAINT FK_BA388B79395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE cart ADD CONSTRAINT FK_BA388B7EBF23851 FOREIGN KEY (delivery_address_id) REFERENCES address (id)');
        $this->addSql('ALTER TABLE cart ADD CONSTRAINT FK_BA388B779D0C0E4 FOREIGN KEY (billing_address_id) REFERENCES address (id)');
        $this->addSql('ALTER TABLE cart_line ADD CONSTRAINT FK_3EF1B4CFBB01DC09 FOREIGN KEY (order_line_id) REFERENCES order_line (id)');
        $this->addSql('ALTER TABLE cart_line ADD CONSTRAINT FK_3EF1B4CF1AD5CDBF FOREIGN KEY (cart_id) REFERENCES cart (id)');
        $this->addSql('ALTER TABLE cart_line ADD CONSTRAINT FK_3EF1B4CFCA263E04 FOREIGN KEY (purchasable_currency_iso) REFERENCES currency (iso)');
        $this->addSql('ALTER TABLE cart_line ADD CONSTRAINT FK_3EF1B4CFB3D2E75A FOREIGN KEY (currency_iso) REFERENCES currency (iso)');
        $this->addSql('ALTER TABLE cart_line ADD CONSTRAINT FK_3EF1B4CF9778C508 FOREIGN KEY (purchasable_id) REFERENCES purchasable (id)');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEE1AD5CDBF FOREIGN KEY (cart_id) REFERENCES cart (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEEAD8238BF FOREIGN KEY (payment_last_state_line_id) REFERENCES state_line (id)');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEE5B8FCE3F FOREIGN KEY (shipping_last_state_line_id) REFERENCES state_line (id)');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEE9395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEEB3D2E75A FOREIGN KEY (currency_iso) REFERENCES currency (iso)');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEECA263E04 FOREIGN KEY (purchasable_currency_iso) REFERENCES currency (iso)');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEEFB17B782 FOREIGN KEY (coupon_currency_iso) REFERENCES currency (iso)');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEEFC817E8F FOREIGN KEY (shipping_currency_iso) REFERENCES currency (iso)');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEEEBF23851 FOREIGN KEY (delivery_address_id) REFERENCES address (id)');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEE79D0C0E4 FOREIGN KEY (billing_address_id) REFERENCES address (id)');
        $this->addSql('ALTER TABLE shipping_state_lines ADD CONSTRAINT FK_B1F98F398D9F6D38 FOREIGN KEY (order_id) REFERENCES orders (id)');
        $this->addSql('ALTER TABLE shipping_state_lines ADD CONSTRAINT FK_B1F98F39B1B0FE4 FOREIGN KEY (state_line_id) REFERENCES state_line (id)');
        $this->addSql('ALTER TABLE payment_state_lines ADD CONSTRAINT FK_CB1ED8408D9F6D38 FOREIGN KEY (order_id) REFERENCES orders (id)');
        $this->addSql('ALTER TABLE payment_state_lines ADD CONSTRAINT FK_CB1ED840B1B0FE4 FOREIGN KEY (state_line_id) REFERENCES state_line (id)');
        $this->addSql('ALTER TABLE order_line ADD CONSTRAINT FK_9CE58EE18D9F6D38 FOREIGN KEY (order_id) REFERENCES orders (id)');
        $this->addSql('ALTER TABLE order_line ADD CONSTRAINT FK_9CE58EE1CA263E04 FOREIGN KEY (purchasable_currency_iso) REFERENCES currency (iso)');
        $this->addSql('ALTER TABLE order_line ADD CONSTRAINT FK_9CE58EE1B3D2E75A FOREIGN KEY (currency_iso) REFERENCES currency (iso)');
        $this->addSql('ALTER TABLE order_line ADD CONSTRAINT FK_9CE58EE19778C508 FOREIGN KEY (purchasable_id) REFERENCES purchasable (id)');
        $this->addSql('ALTER TABLE coupon ADD CONSTRAINT FK_64BF3F0247018B47 FOREIGN KEY (price_currency_iso) REFERENCES currency (iso)');
        $this->addSql('ALTER TABLE coupon ADD CONSTRAINT FK_64BF3F02DCEAE720 FOREIGN KEY (minimum_purchase_currency_iso) REFERENCES currency (iso)');
        $this->addSql('ALTER TABLE coupon ADD CONSTRAINT FK_64BF3F0246D8ACCC FOREIGN KEY (rule) REFERENCES rule (id)');
        $this->addSql('ALTER TABLE currency_exchange_rate ADD CONSTRAINT FK_B9F60EEC5380340B FOREIGN KEY (target_currency_iso) REFERENCES currency (iso)');
        $this->addSql('ALTER TABLE currency_exchange_rate ADD CONSTRAINT FK_B9F60EEC65383BE2 FOREIGN KEY (source_currency_iso) REFERENCES currency (iso)');
        $this->addSql('ALTER TABLE location_inheritance ADD CONSTRAINT FK_CD045D5727ACA70 FOREIGN KEY (parent_id) REFERENCES location (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE location_inheritance ADD CONSTRAINT FK_CD045D53D3D2749 FOREIGN KEY (children_id) REFERENCES location (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE value ADD CONSTRAINT FK_1D775834B6E62EFA FOREIGN KEY (attribute_id) REFERENCES attribute (id)');
        $this->addSql('ALTER TABLE store ADD CONSTRAINT FK_FF575877F98F144A FOREIGN KEY (logo_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE store ADD CONSTRAINT FK_FF5758773C91E28A FOREIGN KEY (secondary_logo_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE store ADD CONSTRAINT FK_FF5758771925D9BF FOREIGN KEY (mobile_logo_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE store ADD CONSTRAINT FK_FF5758778C782417 FOREIGN KEY (header_image_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE store ADD CONSTRAINT FK_FF575877E6DA28AA FOREIGN KEY (background_image_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE store ADD CONSTRAINT FK_FF575877F5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id)');
        $this->addSql('ALTER TABLE store ADD CONSTRAINT FK_FF575877920835C7 FOREIGN KEY (default_language_iso) REFERENCES language (iso)');
        $this->addSql('ALTER TABLE store ADD CONSTRAINT FK_FF575877910402F0 FOREIGN KEY (default_currency_iso) REFERENCES currency (iso)');
        $this->addSql('ALTER TABLE customer ADD CONSTRAINT FK_81398E09EBF23851 FOREIGN KEY (delivery_address_id) REFERENCES address (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE customer ADD CONSTRAINT FK_81398E09C6BDFEB FOREIGN KEY (invoice_address_id) REFERENCES address (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE customer ADD CONSTRAINT FK_81398E09B0DED06D FOREIGN KEY (language_iso) REFERENCES language (iso)');
        $this->addSql('ALTER TABLE customer_address ADD CONSTRAINT FK_1193CB3F9395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id)');
        $this->addSql('ALTER TABLE customer_address ADD CONSTRAINT FK_1193CB3FF5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id)');
        $this->addSql('ALTER TABLE purchasable ADD CONSTRAINT FK_FC2E9BFE5740FE34 FOREIGN KEY (principal_category_id) REFERENCES category (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE purchasable ADD CONSTRAINT FK_FC2E9BFEA7F1F96B FOREIGN KEY (principal_image_id) REFERENCES image (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE purchasable ADD CONSTRAINT FK_FC2E9BFE47018B47 FOREIGN KEY (price_currency_iso) REFERENCES currency (iso)');
        $this->addSql('ALTER TABLE purchasable ADD CONSTRAINT FK_FC2E9BFEEB35D9BE FOREIGN KEY (reduced_price_currency_iso) REFERENCES currency (iso)');
        $this->addSql('ALTER TABLE purchasable ADD CONSTRAINT FK_FC2E9BFEA23B42D FOREIGN KEY (manufacturer_id) REFERENCES manufacturer (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE purchasable_image ADD CONSTRAINT FK_3A78D4124584665A FOREIGN KEY (product_id) REFERENCES purchasable (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE purchasable_image ADD CONSTRAINT FK_3A78D4123DA5256D FOREIGN KEY (image_id) REFERENCES image (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE purchasable_category ADD CONSTRAINT FK_F98077AD9778C508 FOREIGN KEY (purchasable_id) REFERENCES purchasable (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE purchasable_category ADD CONSTRAINT FK_F98077AD12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADE2560A82 FOREIGN KEY (principal_variant_id) REFERENCES variant (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADBF396750 FOREIGN KEY (id) REFERENCES purchasable (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_attribute ADD CONSTRAINT FK_94DA59764584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_attribute ADD CONSTRAINT FK_94DA5976B6E62EFA FOREIGN KEY (attribute_id) REFERENCES attribute (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE variant ADD CONSTRAINT FK_F143BFAD4584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE variant ADD CONSTRAINT FK_F143BFADBF396750 FOREIGN KEY (id) REFERENCES purchasable (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE variant_options ADD CONSTRAINT FK_BF90D7C13B69A9AF FOREIGN KEY (variant_id) REFERENCES variant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE variant_options ADD CONSTRAINT FK_BF90D7C1A7C41D6F FOREIGN KEY (option_id) REFERENCES value (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pack ADD CONSTRAINT FK_97DE5E23BF396750 FOREIGN KEY (id) REFERENCES purchasable (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pack_purchasable ADD CONSTRAINT FK_8D846271919B217 FOREIGN KEY (pack_id) REFERENCES pack (id)');
        $this->addSql('ALTER TABLE pack_purchasable ADD CONSTRAINT FK_8D846279778C508 FOREIGN KEY (purchasable_id) REFERENCES purchasable (id)');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C1727ACA70 FOREIGN KEY (parent_id) REFERENCES category (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE manufacturer ADD CONSTRAINT FK_3D0AE6DCA7F1F96B FOREIGN KEY (principal_image_id) REFERENCES image (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE manufacturer_image ADD CONSTRAINT FK_CE63904F4584665A FOREIGN KEY (product_id) REFERENCES manufacturer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE manufacturer_image ADD CONSTRAINT FK_CE63904F3DA5256D FOREIGN KEY (image_id) REFERENCES image (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE menu_node_hierarchy ADD CONSTRAINT FK_F80FD5E9CED68269 FOREIGN KEY (menu_node_id) REFERENCES menu (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE menu_node_hierarchy ADD CONSTRAINT FK_F80FD5E92CC283CA FOREIGN KEY (menu_subnode_id) REFERENCES menu_node (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE node_hierarchy ADD CONSTRAINT FK_E1C520CDCED68269 FOREIGN KEY (menu_node_id) REFERENCES menu_node (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE node_hierarchy ADD CONSTRAINT FK_E1C520CD2CC283CA FOREIGN KEY (menu_subnode_id) REFERENCES menu_node (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cart_coupon ADD CONSTRAINT FK_6A3B5D5D1AD5CDBF FOREIGN KEY (cart_id) REFERENCES cart (id)');
        $this->addSql('ALTER TABLE cart_coupon ADD CONSTRAINT FK_6A3B5D5D66C5951B FOREIGN KEY (coupon_id) REFERENCES coupon (id)');
        $this->addSql('ALTER TABLE order_coupon ADD CONSTRAINT FK_A7302FD78D9F6D38 FOREIGN KEY (order_id) REFERENCES orders (id)');
        $this->addSql('ALTER TABLE order_coupon ADD CONSTRAINT FK_A7302FD766C5951B FOREIGN KEY (coupon_id) REFERENCES coupon (id)');
        $this->addSql('ALTER TABLE order_coupon ADD CONSTRAINT FK_A7302FD7D82D7CDD FOREIGN KEY (amount_currency_iso) REFERENCES currency (iso)');
        $this->addSql('ALTER TABLE banner ADD CONSTRAINT FK_6F9DB8E73DA5256D FOREIGN KEY (image_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE banner ADD CONSTRAINT FK_6F9DB8E7A7F1F96B FOREIGN KEY (principal_image_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE banner_banner_zone ADD CONSTRAINT FK_98251B1E684EC833 FOREIGN KEY (banner_id) REFERENCES banner (id)');
        $this->addSql('ALTER TABLE banner_banner_zone ADD CONSTRAINT FK_98251B1ECB711668 FOREIGN KEY (banner_zone_id) REFERENCES banner_zone (id)');
        $this->addSql('ALTER TABLE banner_zone ADD CONSTRAINT FK_A852916DB0DED06D FOREIGN KEY (language_iso) REFERENCES language (iso)');
        $this->addSql('ALTER TABLE newsletter_subscription ADD CONSTRAINT FK_A82B55ADB0DED06D FOREIGN KEY (language_iso) REFERENCES language (iso)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C727ACA70 FOREIGN KEY (parent_id) REFERENCES comment (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE comment_vote ADD CONSTRAINT FK_7C262788F8697D13 FOREIGN KEY (comment_id) REFERENCES comment (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE authorization ADD CONSTRAINT FK_7A6D8BEFA76ED395 FOREIGN KEY (user_id) REFERENCES customer (id)');
        $this->addSql('ALTER TABLE shipping_range ADD CONSTRAINT FK_7D1887F321DFC797 FOREIGN KEY (carrier_id) REFERENCES carrier (id)');
        $this->addSql('ALTER TABLE shipping_range ADD CONSTRAINT FK_7D1887F31972DC04 FOREIGN KEY (from_zone_id) REFERENCES zone (id)');
        $this->addSql('ALTER TABLE shipping_range ADD CONSTRAINT FK_7D1887F311B4025E FOREIGN KEY (to_zone_id) REFERENCES zone (id)');
        $this->addSql('ALTER TABLE shipping_range ADD CONSTRAINT FK_7D1887F347018B47 FOREIGN KEY (price_currency_iso) REFERENCES currency (iso)');
        $this->addSql('ALTER TABLE shipping_range ADD CONSTRAINT FK_7D1887F3D6956502 FOREIGN KEY (from_price_currency_iso) REFERENCES currency (iso)');
        $this->addSql('ALTER TABLE shipping_range ADD CONSTRAINT FK_7D1887F315643E2F FOREIGN KEY (to_price_currency_iso) REFERENCES currency (iso)');
        $this->addSql('ALTER TABLE carrier ADD CONSTRAINT FK_4739F11CB2A824D8 FOREIGN KEY (tax_id) REFERENCES tax (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE cart_line DROP FOREIGN KEY FK_3EF1B4CF1AD5CDBF');
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEE1AD5CDBF');
        $this->addSql('ALTER TABLE cart_coupon DROP FOREIGN KEY FK_6A3B5D5D1AD5CDBF');
        $this->addSql('ALTER TABLE shipping_state_lines DROP FOREIGN KEY FK_B1F98F398D9F6D38');
        $this->addSql('ALTER TABLE payment_state_lines DROP FOREIGN KEY FK_CB1ED8408D9F6D38');
        $this->addSql('ALTER TABLE order_line DROP FOREIGN KEY FK_9CE58EE18D9F6D38');
        $this->addSql('ALTER TABLE order_coupon DROP FOREIGN KEY FK_A7302FD78D9F6D38');
        $this->addSql('ALTER TABLE cart_line DROP FOREIGN KEY FK_3EF1B4CFBB01DC09');
        $this->addSql('ALTER TABLE cart_coupon DROP FOREIGN KEY FK_6A3B5D5D66C5951B');
        $this->addSql('ALTER TABLE order_coupon DROP FOREIGN KEY FK_A7302FD766C5951B');
        $this->addSql('ALTER TABLE coupon DROP FOREIGN KEY FK_64BF3F0246D8ACCC');
        $this->addSql('ALTER TABLE cart_line DROP FOREIGN KEY FK_3EF1B4CFCA263E04');
        $this->addSql('ALTER TABLE cart_line DROP FOREIGN KEY FK_3EF1B4CFB3D2E75A');
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEEB3D2E75A');
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEECA263E04');
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEEFB17B782');
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEEFC817E8F');
        $this->addSql('ALTER TABLE order_line DROP FOREIGN KEY FK_9CE58EE1CA263E04');
        $this->addSql('ALTER TABLE order_line DROP FOREIGN KEY FK_9CE58EE1B3D2E75A');
        $this->addSql('ALTER TABLE coupon DROP FOREIGN KEY FK_64BF3F0247018B47');
        $this->addSql('ALTER TABLE coupon DROP FOREIGN KEY FK_64BF3F02DCEAE720');
        $this->addSql('ALTER TABLE currency_exchange_rate DROP FOREIGN KEY FK_B9F60EEC5380340B');
        $this->addSql('ALTER TABLE currency_exchange_rate DROP FOREIGN KEY FK_B9F60EEC65383BE2');
        $this->addSql('ALTER TABLE store DROP FOREIGN KEY FK_FF575877910402F0');
        $this->addSql('ALTER TABLE purchasable DROP FOREIGN KEY FK_FC2E9BFE47018B47');
        $this->addSql('ALTER TABLE purchasable DROP FOREIGN KEY FK_FC2E9BFEEB35D9BE');
        $this->addSql('ALTER TABLE order_coupon DROP FOREIGN KEY FK_A7302FD7D82D7CDD');
        $this->addSql('ALTER TABLE shipping_range DROP FOREIGN KEY FK_7D1887F347018B47');
        $this->addSql('ALTER TABLE shipping_range DROP FOREIGN KEY FK_7D1887F3D6956502');
        $this->addSql('ALTER TABLE shipping_range DROP FOREIGN KEY FK_7D1887F315643E2F');
        $this->addSql('ALTER TABLE store DROP FOREIGN KEY FK_FF575877920835C7');
        $this->addSql('ALTER TABLE customer DROP FOREIGN KEY FK_81398E09B0DED06D');
        $this->addSql('ALTER TABLE banner_zone DROP FOREIGN KEY FK_A852916DB0DED06D');
        $this->addSql('ALTER TABLE newsletter_subscription DROP FOREIGN KEY FK_A82B55ADB0DED06D');
        $this->addSql('ALTER TABLE store DROP FOREIGN KEY FK_FF575877F98F144A');
        $this->addSql('ALTER TABLE store DROP FOREIGN KEY FK_FF5758773C91E28A');
        $this->addSql('ALTER TABLE store DROP FOREIGN KEY FK_FF5758771925D9BF');
        $this->addSql('ALTER TABLE store DROP FOREIGN KEY FK_FF5758778C782417');
        $this->addSql('ALTER TABLE store DROP FOREIGN KEY FK_FF575877E6DA28AA');
        $this->addSql('ALTER TABLE purchasable DROP FOREIGN KEY FK_FC2E9BFEA7F1F96B');
        $this->addSql('ALTER TABLE purchasable_image DROP FOREIGN KEY FK_3A78D4123DA5256D');
        $this->addSql('ALTER TABLE manufacturer DROP FOREIGN KEY FK_3D0AE6DCA7F1F96B');
        $this->addSql('ALTER TABLE manufacturer_image DROP FOREIGN KEY FK_CE63904F3DA5256D');
        $this->addSql('ALTER TABLE banner DROP FOREIGN KEY FK_6F9DB8E73DA5256D');
        $this->addSql('ALTER TABLE banner DROP FOREIGN KEY FK_6F9DB8E7A7F1F96B');
        $this->addSql('ALTER TABLE cart DROP FOREIGN KEY FK_BA388B7EBF23851');
        $this->addSql('ALTER TABLE cart DROP FOREIGN KEY FK_BA388B779D0C0E4');
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEEEBF23851');
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEE79D0C0E4');
        $this->addSql('ALTER TABLE store DROP FOREIGN KEY FK_FF575877F5B7AF75');
        $this->addSql('ALTER TABLE customer DROP FOREIGN KEY FK_81398E09EBF23851');
        $this->addSql('ALTER TABLE customer DROP FOREIGN KEY FK_81398E09C6BDFEB');
        $this->addSql('ALTER TABLE customer_address DROP FOREIGN KEY FK_1193CB3FF5B7AF75');
        $this->addSql('ALTER TABLE location_inheritance DROP FOREIGN KEY FK_CD045D5727ACA70');
        $this->addSql('ALTER TABLE location_inheritance DROP FOREIGN KEY FK_CD045D53D3D2749');
        $this->addSql('ALTER TABLE value DROP FOREIGN KEY FK_1D775834B6E62EFA');
        $this->addSql('ALTER TABLE product_attribute DROP FOREIGN KEY FK_94DA5976B6E62EFA');
        $this->addSql('ALTER TABLE variant_options DROP FOREIGN KEY FK_BF90D7C1A7C41D6F');
        $this->addSql('ALTER TABLE cart DROP FOREIGN KEY FK_BA388B79395C3F3');
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEE9395C3F3');
        $this->addSql('ALTER TABLE customer_address DROP FOREIGN KEY FK_1193CB3F9395C3F3');
        $this->addSql('ALTER TABLE authorization DROP FOREIGN KEY FK_7A6D8BEFA76ED395');
        $this->addSql('ALTER TABLE cart_line DROP FOREIGN KEY FK_3EF1B4CF9778C508');
        $this->addSql('ALTER TABLE order_line DROP FOREIGN KEY FK_9CE58EE19778C508');
        $this->addSql('ALTER TABLE purchasable_image DROP FOREIGN KEY FK_3A78D4124584665A');
        $this->addSql('ALTER TABLE purchasable_category DROP FOREIGN KEY FK_F98077AD9778C508');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04ADBF396750');
        $this->addSql('ALTER TABLE variant DROP FOREIGN KEY FK_F143BFADBF396750');
        $this->addSql('ALTER TABLE pack DROP FOREIGN KEY FK_97DE5E23BF396750');
        $this->addSql('ALTER TABLE pack_purchasable DROP FOREIGN KEY FK_8D846279778C508');
        $this->addSql('ALTER TABLE product_attribute DROP FOREIGN KEY FK_94DA59764584665A');
        $this->addSql('ALTER TABLE variant DROP FOREIGN KEY FK_F143BFAD4584665A');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04ADE2560A82');
        $this->addSql('ALTER TABLE variant_options DROP FOREIGN KEY FK_BF90D7C13B69A9AF');
        $this->addSql('ALTER TABLE pack_purchasable DROP FOREIGN KEY FK_8D846271919B217');
        $this->addSql('ALTER TABLE purchasable DROP FOREIGN KEY FK_FC2E9BFE5740FE34');
        $this->addSql('ALTER TABLE purchasable_category DROP FOREIGN KEY FK_F98077AD12469DE2');
        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C1727ACA70');
        $this->addSql('ALTER TABLE purchasable DROP FOREIGN KEY FK_FC2E9BFEA23B42D');
        $this->addSql('ALTER TABLE manufacturer_image DROP FOREIGN KEY FK_CE63904F4584665A');
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEEAD8238BF');
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEE5B8FCE3F');
        $this->addSql('ALTER TABLE shipping_state_lines DROP FOREIGN KEY FK_B1F98F39B1B0FE4');
        $this->addSql('ALTER TABLE payment_state_lines DROP FOREIGN KEY FK_CB1ED840B1B0FE4');
        $this->addSql('ALTER TABLE shipping_range DROP FOREIGN KEY FK_7D1887F31972DC04');
        $this->addSql('ALTER TABLE shipping_range DROP FOREIGN KEY FK_7D1887F311B4025E');
        $this->addSql('ALTER TABLE carrier DROP FOREIGN KEY FK_4739F11CB2A824D8');
        $this->addSql('ALTER TABLE menu_node_hierarchy DROP FOREIGN KEY FK_F80FD5E9CED68269');
        $this->addSql('ALTER TABLE menu_node_hierarchy DROP FOREIGN KEY FK_F80FD5E92CC283CA');
        $this->addSql('ALTER TABLE node_hierarchy DROP FOREIGN KEY FK_E1C520CDCED68269');
        $this->addSql('ALTER TABLE node_hierarchy DROP FOREIGN KEY FK_E1C520CD2CC283CA');
        $this->addSql('ALTER TABLE banner_banner_zone DROP FOREIGN KEY FK_98251B1E684EC833');
        $this->addSql('ALTER TABLE banner_banner_zone DROP FOREIGN KEY FK_98251B1ECB711668');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C727ACA70');
        $this->addSql('ALTER TABLE comment_vote DROP FOREIGN KEY FK_7C262788F8697D13');
        $this->addSql('ALTER TABLE shipping_range DROP FOREIGN KEY FK_7D1887F321DFC797');
        $this->addSql('DROP TABLE cart');
        $this->addSql('DROP TABLE cart_line');
        $this->addSql('DROP TABLE orders');
        $this->addSql('DROP TABLE shipping_state_lines');
        $this->addSql('DROP TABLE payment_state_lines');
        $this->addSql('DROP TABLE order_line');
        $this->addSql('DROP TABLE coupon');
        $this->addSql('DROP TABLE rule');
        $this->addSql('DROP TABLE currency');
        $this->addSql('DROP TABLE currency_exchange_rate');
        $this->addSql('DROP TABLE language');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE address');
        $this->addSql('DROP TABLE location');
        $this->addSql('DROP TABLE location_inheritance');
        $this->addSql('DROP TABLE attribute');
        $this->addSql('DROP TABLE value');
        $this->addSql('DROP TABLE store');
        $this->addSql('DROP TABLE admin_user');
        $this->addSql('DROP TABLE customer');
        $this->addSql('DROP TABLE customer_address');
        $this->addSql('DROP TABLE purchasable');
        $this->addSql('DROP TABLE purchasable_image');
        $this->addSql('DROP TABLE purchasable_category');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE product_attribute');
        $this->addSql('DROP TABLE variant');
        $this->addSql('DROP TABLE variant_options');
        $this->addSql('DROP TABLE pack');
        $this->addSql('DROP TABLE pack_purchasable');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE manufacturer');
        $this->addSql('DROP TABLE manufacturer_image');
        $this->addSql('DROP TABLE state_line');
        $this->addSql('DROP TABLE zone');
        $this->addSql('DROP TABLE tax');
        $this->addSql('DROP TABLE entity_translation');
        $this->addSql('DROP TABLE menu');
        $this->addSql('DROP TABLE menu_node_hierarchy');
        $this->addSql('DROP TABLE menu_node');
        $this->addSql('DROP TABLE node_hierarchy');
        $this->addSql('DROP TABLE plugin');
        $this->addSql('DROP TABLE cart_coupon');
        $this->addSql('DROP TABLE order_coupon');
        $this->addSql('DROP TABLE banner');
        $this->addSql('DROP TABLE banner_banner_zone');
        $this->addSql('DROP TABLE banner_zone');
        $this->addSql('DROP TABLE newsletter_subscription');
        $this->addSql('DROP TABLE page');
        $this->addSql('DROP TABLE metric_entry');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE comment_vote');
        $this->addSql('DROP TABLE authorization');
        $this->addSql('DROP TABLE shipping_range');
        $this->addSql('DROP TABLE carrier');
    }
}
