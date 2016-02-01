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
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

use Elcodi\Component\Currency\Entity\Money;

/**
 * Class MinimumMoneyValidator
 */
class MinimumMoneyValidator extends ConstraintValidator
{
    /**
     * Validates the value to be greater or equal than the constraint value.
     *
     * @param Money      $value      Value
     * @param Constraint $constraint Constraint
     *
     * @return null
     */
    public function validate($value, Constraint $constraint)
    {
        if (null === $value) {
            return null;
        }

        if (!($value instanceof Money)) {
            throw new UnexpectedTypeException($value, 'Elcodi\Component\Currency\Entity\Money');
        }

        $minimumMoney = Money::create($constraint->value, $value->getCurrency());

        if ($value->isLessThan($minimumMoney)) {
            $this
                ->context
                ->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $this->formatValue($value, self::OBJECT_TO_STRING))
                ->setParameter('{{ compared_value }}', $this->formatValue($minimumMoney, self::OBJECT_TO_STRING))
                ->setParameter('{{ compared_value_type }}', $this->formatTypeOf($minimumMoney))
                ->addViolation();
        }
    }
}
