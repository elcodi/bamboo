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

namespace Elcodi\Admin\ProductBundle\Validation;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\ConstraintDefinitionException;

use Elcodi\Component\Currency\Entity\Money;

/**
 * Class MinimumMoney
 */
class MinimumMoney extends Constraint
{
    /**
     * @var string
     *
     * Constraint message
     */
    public $message = 'This value should be greater than or equal to {{ compared_value }}.';

    /**
     * Value to be validated.
     *
     * @var Money
     */
    public $value;

    /**
     * Builds a new class.
     *
     * @param array $options
     */
    public function __construct($options = null)
    {
        if (is_array($options) && !isset($options['value'])) {
            throw new ConstraintDefinitionException(sprintf(
                'The %s constraint requires the "value" option to be set.',
                get_class($this)
            ));
        }

        parent::__construct($options);
    }

    /**
     * Returns default option.
     *
     * @return string
     */
    public function getDefaultOption()
    {
        return 'value';
    }
}
