<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * This distribution is just a basic e-commerce implementation based on
 * Elcodi project.
 *
 * Feel free to edit it, and make your own
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Store\StoreCartBundle\EventListener;

use Elcodi\CartBundle\Wrapper\CartWrapper;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * Class CartCustomerEventListener
 *
 * This event listeners associates current cart with current customer.
 *
 * This event is useless if current customer is not autenticated ( not ID )
 */
class CartCustomerEventListener
{
    /**
     * @var SecurityContextInterface
     *
     * securityContext
     */
    protected $securityContext;

    /**
     * @var CartWrapper
     *
     * cartWrapper
     */
    protected $cartWrapper;

    public function __construct(
        SecurityContextInterface $securityContext,
        CartWrapper $cartWrapper
    )
    {
        $this->securityContext = $securityContext;
        $this->cartWrapper = $cartWrapper;
    }

    /**
     * On kernel request
     *
     * This method get last cart loaded and not ordered.
     *
     * If exists
     *
     * @param GetResponseEvent $event Event
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        $token = $this->securityContext->getToken();

        if ($token instanceof UsernamePasswordToken) {

            $user = $token->getUser();
            $cart = $this->cartWrapper->loadCart();
            $cart->setCustomer($user);
        }

    }
}
