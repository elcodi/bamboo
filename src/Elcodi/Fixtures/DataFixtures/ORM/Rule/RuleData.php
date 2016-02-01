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
            ->setName('Importe inferior a 300€')
            ->setExpression('cart.getPurchasableAmount().isLessThan(money(300))');
        $manager->persist($ruleLowCost);

        $ruleFewItems = $ruleFactory
            ->create()
            ->setName('Menos de 3 productos')
            ->setExpression('cart.getQuantity() < 3');
        $manager->persist($ruleFewItems);

        $ruleDiscount = $ruleFactory
            ->create()
            ->setName('Superior a 300€ y menos de 3 productos')
            ->setExpression('not rule("Importe inferior a 300€") and rule("Menos de 3 productos")');
        $manager->persist($ruleDiscount);

        $this->setReference('rule-big-spender', $ruleDiscount);

        $manager->flush();
    }
}
