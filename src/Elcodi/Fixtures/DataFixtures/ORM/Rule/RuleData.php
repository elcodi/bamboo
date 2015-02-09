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

namespace Elcodi\Fixtures\DataFixtures\ORM\Rule;

use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;

/**
 * Class RuleData
 */
class RuleData extends AbstractFixture
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $ruleFactory = $this->getFactory('rule');

        $ruleLowCost = $ruleFactory
            ->create()
            ->setName('low_cost')
            ->setExpression('cart.getProductAmount().isLessThan(money(300))')
        ;
        $manager->persist($ruleLowCost);

        $ruleFewItems = $ruleFactory
            ->create()
            ->setName('few_items')
            ->setExpression('cart.getQuantity() < 3')
        ;
        $manager->persist($ruleFewItems);

        $ruleDiscount = $ruleFactory
            ->create()
            ->setName('big_spender')
            ->setExpression('not rule("low_cost") and rule("few_items")')
        ;
        $manager->persist($ruleDiscount);

        $this->setReference('rule-big-spender', $ruleDiscount);

        $manager->flush();
    }
}
