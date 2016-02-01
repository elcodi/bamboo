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

namespace Elcodi\Admin\CartBundle\Controller;

use Mmoreram\ControllerExtraBundle\Annotation\Entity as EntityAnnotation;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

use Elcodi\Admin\CoreBundle\Controller\Abstracts\AbstractAdminController;
use Elcodi\Component\Cart\Entity\Interfaces\OrderInterface;
use Elcodi\Component\StateTransitionMachine\Entity\Interfaces\StateLineInterface;

/**
 * Class Controller for Order
 *
 * @Route(
 *      path = "/order",
 * )
 */
class OrderController extends AbstractAdminController
{
    /**
     * List elements of certain entity type.
     *
     * This action is just a wrapper, so should never get any data,
     * as this is component responsibility
     *
     * @param integer $page             Page
     * @param integer $limit            Limit of items per page
     * @param string  $orderByField     Field to order by
     * @param string  $orderByDirection Direction to order by
     *
     * @return array Result
     *
     * @Route(
     *      path = "s/{page}/{limit}/{orderByField}/{orderByDirection}",
     *      name = "admin_order_list",
     *      requirements = {
     *          "page" = "\d*",
     *          "limit" = "\d*",
     *      },
     *      defaults = {
     *          "page" = "1",
     *          "limit" = "50",
     *          "orderByField" = "id",
     *          "orderByDirection" = "DESC",
     *      },
     *      methods = {"GET"}
     * )
     * @Template
     */
    public function listAction(
        $page,
        $limit,
        $orderByField,
        $orderByDirection
    ) {
        return [
            'page'             => $page,
            'limit'            => $limit,
            'orderByField'     => $orderByField,
            'orderByDirection' => $orderByDirection,
        ];
    }

    /**
     * Edit and Saves order
     *
     * @param OrderInterface $order Order
     *
     * @return array Data
     *
     * @Route(
     *      path = "/{id}",
     *      name = "admin_order_edit",
     *      requirements = {
     *          "id" = "\d+",
     *      },
     *      methods = {"GET"}
     * )
     * @Template
     *
     * @EntityAnnotation(
     *      class = "elcodi.entity.order.class",
     *      name = "order",
     *      mapping = {
     *          "id" = "~id~"
     *      }
     * )
     */
    public function editAction(OrderInterface $order)
    {
        $nextPaymentTransitions = $this
            ->get('elcodi.order.payment_states_machine')
            ->getAvailableStates(
                $order
                    ->getPaymentStateLineStack()
                    ->getLastStateLine()
                    ->getName()
            );

        $nextShippingTransitions = $this
            ->get('elcodi.order.shipping_states_machine')
            ->getAvailableStates(
                $order
                    ->getShippingStateLineStack()
                    ->getLastStateLine()
                    ->getName()
            );

        $allStates = array_merge(
            $order
                ->getPaymentStateLineStack()
                ->getStateLines()
                ->toArray(),
            $order
                ->getShippingStateLineStack()
                ->getStateLines()
                ->toArray()
        );

        usort($allStates, function (StateLineInterface $a, StateLineInterface $b) {
            return $a->getCreatedAt() == $b->getCreatedAt()
                ? $a->getId() > $b->getId()
                : $a->getCreatedAt() > $b->getCreatedAt();
        });

        $addressFormatter = $this->get('elcodi.formatter.address');
        $deliveryAddress  = $order->getDeliveryAddress();
        $deliveryInfo     = $addressFormatter->toArray($deliveryAddress);

        $billingAddress   = $order->getBillingAddress();
        $billingInfo      = $addressFormatter->toArray($billingAddress);

        return [
            'order'                   => $order,
            'nextPaymentTransitions'  => $nextPaymentTransitions,
            'nextShippingTransitions' => $nextShippingTransitions,
            'allStates'               => $allStates,
            'deliveryInfo'            => $deliveryInfo,
            'billingInfo'             => $billingInfo,
        ];
    }

    /**
     * Change payment state
     *
     * @param Request        $request    Request
     * @param OrderInterface $order      Order
     * @param string         $transition Verb to apply
     *
     * @return RedirectResponse Back to referrer
     *
     * @Route(
     *      path = "/{id}/payment/{transition}",
     *      name = "admin_order_change_payment_state",
     *      requirements = {
     *          "id" = "\d+",
     *      },
     *      methods = {"GET"}
     * )
     *
     * @EntityAnnotation(
     *      class = "elcodi.entity.order.class",
     *      name = "order",
     *      mapping = {
     *          "id" = "~id~"
     *      }
     * )
     */
    public function changePaymentStateAction(
        Request $request,
        OrderInterface $order,
        $transition
    ) {
        $stateLineStack = $this
            ->get('elcodi.order_payment_states_machine_manager')
            ->transition(
                $order,
                $order->getPaymentStateLineStack(),
                $transition,
                ''
            );

        $order->setPaymentStateLineStack($stateLineStack);
        $this->flush($order);

        return $this->redirect($request->headers->get('referer'));
    }

    /**
     * Change shipping state
     *
     * @param Request        $request    Request
     * @param OrderInterface $order      Order
     * @param string         $transition Verb to apply
     *
     * @return RedirectResponse Back to referrer
     *
     * @Route(
     *      path = "/{id}/shipping/{transition}",
     *      name = "admin_order_change_shipping_state",
     *      requirements = {
     *          "id" = "\d+",
     *      },
     *      methods = {"GET"}
     * )
     *
     * @EntityAnnotation(
     *      class = "elcodi.entity.order.class",
     *      name = "order",
     *      mapping = {
     *          "id" = "~id~"
     *      }
     * )
     */
    public function changeShippingStateAction(
        Request $request,
        OrderInterface $order,
        $transition
    ) {
        $stateLineStack = $this
            ->get('elcodi.order_shipping_states_machine_manager')
            ->transition(
                $order,
                $order->getShippingStateLineStack(),
                $transition,
                ''
            );

        $order->setShippingStateLineStack($stateLineStack);
        $this->flush($order);

        return $this->redirect($request->headers->get('referer'));
    }
}
