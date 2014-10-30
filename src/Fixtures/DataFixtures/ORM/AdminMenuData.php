<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Feel free to edit as you please, and have fun.
 *
 * @author Marc Morera <yuhu@mmoreram.com>
 * @author Aldo Chiecchia <zimage@tiscali.it>
 */

namespace Elcodi\Fixtures\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\Component\Menu\Entity\Menu\Menu;
use Elcodi\Component\Menu\Entity\Menu\Node;

/**
 * Class AdminMenuData
 *
 * Fixtures for Bamboo Admin side menu
 */
class AdminMenuData extends AbstractFixture
{
    /**
     * Factors a new menu Node
     *
     * Alias for elcodi.factory.menu service create() method
     *
     * @return Node
     */
    private function createNewNode()
    {
        return $this
            ->container
            ->get('elcodi.factory.menu_node')
            ->create();
    }

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        /**
         * User
         */

        $adminUsersNode = $this
            ->createNewNode()
            ->setName('Admin users')
            ->setUrl('admin_admin_user_list')
            ->enable();

        $manager->persist($adminUsersNode);

        $customersNode = $this
            ->createNewNode()
            ->setName('Customers')
            ->setUrl('admin_customer_list')
            ->enable();

        $manager->persist($customersNode);

        $userNode = $this
            ->createNewNode()
            ->setName('User')
            ->setCode('users')
            ->addSubnode($adminUsersNode)
            ->addSubnode($customersNode)
            ->enable();

        $manager->persist($userNode);

        /**
         * Catalog
         */

        $productsNode = $this
            ->createNewNode()
            ->setName('Products')
            ->setUrl('admin_product_list')
            ->enable();

        $manager->persist($productsNode);

        $categoriesNode = $this
            ->createNewNode()
            ->setName('Categories')
            ->setUrl('admin_category_list')
            ->enable();

        $manager->persist($categoriesNode);

        $manufacturersNode = $this
            ->createNewNode()
            ->setName('Manufacturers')
            ->setUrl('admin_manufacturer_list')
            ->enable();

        $manager->persist($manufacturersNode);

        $catalogNode = $this
            ->createNewNode()
            ->setName('Catalog')
            ->setCode('tags')
            ->setUrl('')
            ->addSubnode($productsNode)
            ->addSubnode($categoriesNode)
            ->addSubnode($manufacturersNode)
            ->enable();

        $manager->persist($catalogNode);

        /*
         * Purchases
         */

        $cartsNode = $this
            ->createNewNode()
            ->setName('Carts')
            ->setUrl('admin_cart_list')
            ->enable();

        $manager->persist($cartsNode);

        $ordersNode = $this
            ->createNewNode()
            ->setName('Orders')
            ->setUrl('admin_order_list')
            ->enable();

        $manager->persist($ordersNode);

        $purchasesNode = $this
            ->createNewNode()
            ->setName('Purchases')
            ->setCode('shopping-cart')
            ->setUrl('')
            ->addSubnode($cartsNode)
            ->addSubnode($ordersNode)
            ->enable();

        $manager->persist($purchasesNode);

        /*
         * Media server
         */

        $mediasNode = $this
            ->createNewNode()
            ->setName('Medias')
            ->setCode('picture-o')
            ->setUrl('admin_image_list')
            ->enable();

        $manager->persist($mediasNode);

        /*
         * Banners
         */

        $bannerzonesNode = $this
            ->createNewNode()
            ->setName('Banner Zones')
            ->setUrl('admin_banner_zone_list')
            ->enable();

        $manager->persist($bannerzonesNode);

        $simpleBannersNode = $this
            ->createNewNode()
            ->setName('Banners')
            ->setUrl('admin_banner_list')
            ->enable();

        $manager->persist($simpleBannersNode);

        $bannersNode = $this
            ->createNewNode()
            ->setName('Banners')
            ->setUrl('')
            ->addSubnode($bannerzonesNode)
            ->addSubnode($simpleBannersNode)
            ->enable();

        $manager->persist($bannersNode);

        /*
         * Coupon
         */

        $couponsNode = $this
            ->createNewNode()
            ->setName('Coupons')
            ->setUrl('admin_coupon_list')
            ->enable();

        $manager->persist($couponsNode);

        /*
         * Currencies
         */

        $currenciesNode = $this
            ->createNewNode()
            ->setName('Currencies')
            ->setCode('btc')
            ->setUrl('admin_currency_list')
            ->enable();

        $manager->persist($currenciesNode);

        /*
         * Rules
         */

        $ruleGroupsNode = $this
            ->createNewNode()
            ->setName('Rule Groups')
            ->setUrl('admin_rule_group_list')
            ->enable();

        $manager->persist($ruleGroupsNode);

        $simpleRulesNode = $this
            ->createNewNode()
            ->setName('Rules')
            ->setUrl('admin_rule_list')
            ->enable();

        $manager->persist($simpleRulesNode);

        $rulesNode = $this
            ->createNewNode()
            ->setName('Rules')
            ->setUrl('')
            ->addSubnode($ruleGroupsNode)
            ->addSubnode($simpleRulesNode)
            ->enable();

        $manager->persist($rulesNode);

        /*
         * Admin side Menu
         */

        /**
         * @var Menu $adminMenu
         */
        $adminMenu = $this
            ->container
            ->get('elcodi.factory.menu')
            ->create();

        $adminMenu
            ->setCode('admin')
            ->addSubnode($userNode)
            ->addSubnode($catalogNode)
            ->addSubnode($purchasesNode)
            ->addSubnode($mediasNode)
            ->addSubnode($bannersNode)
            ->addSubnode($couponsNode)
            ->addSubnode($currenciesNode)
            ->addSubnode($rulesNode)
            ->enable();

        $manager->persist($adminMenu);
        $this->addReference('menu-admin', $adminMenu);

        $manager->flush();
    }
}
