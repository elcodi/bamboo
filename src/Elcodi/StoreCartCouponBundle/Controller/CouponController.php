<?php

/**
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

namespace Elcodi\StoreCartCouponBundle\Controller;

use Mmoreram\ControllerExtraBundle\Annotation\Form as AnnotationForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormView;

use Elcodi\Component\Cart\Entity\Interfaces\CartInterface;

/**
 * Class CouponController
 *
 * @Route(
 *      path = "/coupon",
 * )
 */
class CouponController extends Controller
{
    /**
     * Cart coupon form
     *
     * @param FormView $couponApplyFormView Coupon Apply view
     *
     * @return array
     *
     * @Route(
     *      path = "/view",
     *      name = "store_coupon_view"
     * )
     * @Method("GET")
     * @Template
     *
     * @AnnotationForm(
     *      class = "store_cart_coupon_form_type_coupon_apply",
     *      name  = "couponApplyFormView"
     * )
     */
    public function viewAction(FormView $couponApplyFormView)
    {
        return [
            'form' => $couponApplyFormView,
        ];
    }

    /**
     * Add coupon to cart
     *
     * @param Form $couponApplyFormType Coupon Apply type
     *
     * @return array
     *
     * @Route(
     *      path = "/apply",
     *      name = "store_coupon_apply"
     * )
     * @Method("POST")
     *
     * @AnnotationForm(
     *      class = "store_cart_coupon_form_type_coupon_apply",
     *      name  = "couponApplyFormType",
     *      handleRequest = true,
     * )
     */
    public function applyAction(Form $couponApplyFormType)
    {
        $couponCode = $couponApplyFormType->getData()['code'];

        /**
         * @var CartInterface $cart
         */
        $cart = $this
            ->get('elcodi.cart_wrapper')
            ->loadCart();

        $this
            ->get('elcodi.cart_coupon_manager')
            ->addCouponByCode($cart, $couponCode);

        return $this->redirect($this->generateUrl('store_cart_view'));
    }

    /**
     * Remove coupon from cart
     *
     * @param string $code Coupon code
     *
     * @return array
     *
     * @Route(
     *      path = "/remove/{code}",
     *      name = "store_coupon_remove"
     * )
     * @Method("GET")
     */
    public function removeAction($code)
    {
        /**
         * @var CartInterface $cart
         */
        $cart = $this
            ->get('elcodi.cart_wrapper')
            ->loadCart();

        $this
            ->get('elcodi.cart_coupon_manager')
            ->removeCouponByCode($cart, $code);

        return $this->redirect($this->generateUrl('store_cart_view'));
    }
}
