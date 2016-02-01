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

namespace Elcodi\Store\CartCouponBundle\Controller;

use Mmoreram\ControllerExtraBundle\Annotation\Form as AnnotationForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Response;

use Elcodi\Component\Cart\Entity\Interfaces\CartInterface;
use Elcodi\Component\Coupon\Exception\Abstracts\AbstractCouponException;
use Elcodi\Store\CoreBundle\Controller\Traits\TemplateRenderTrait;

/**
 * Class CouponController
 *
 * @Route(
 *      path = "/coupon",
 * )
 */
class CouponController extends Controller
{
    use TemplateRenderTrait;

    /**
     * Cart coupon form
     *
     * @param FormView $couponApplyFormView Coupon Apply view
     *
     * @return Response Response
     *
     * @Route(
     *      path = "/view",
     *      name = "store_coupon_view",
     *      methods = {"GET"}
     * )
     *
     * @AnnotationForm(
     *      class = "store_cart_coupon_form_type_coupon_apply",
     *      name  = "couponApplyFormView"
     * )
     */
    public function viewAction(FormView $couponApplyFormView)
    {
        return $this->renderTemplate(
            'Subpages:coupon-add.html.twig',
            [
                'form' => $couponApplyFormView,
            ]
        );
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
     *      name = "store_coupon_apply",
     *      methods = {"POST"}
     * )
     *
     * @AnnotationForm(
     *      class = "store_cart_coupon_form_type_coupon_apply",
     *      name  = "couponApplyFormType",
     *      handleRequest = true,
     * )
     */
    public function applyAction(Form $couponApplyFormType)
    {
        $translator = $this->get('translator');
        $couponCode = $couponApplyFormType
            ->get('code')
            ->getData();

        /**
         * @var CartInterface $cart
         */
        $cart = $this
            ->get('elcodi.wrapper.cart')
            ->get();

        try {
            $this
                ->get('elcodi.manager.cart_coupon')
                ->addCouponByCode($cart, $couponCode);

            $message = $translator->trans('store.coupon.applied.message_ok');
            $this->addFlash('info', $message);
        } catch (AbstractCouponException $e) {
            $message = $translator->trans('store.coupon.applied.message_ko');
            $this->addFlash('error', $message);
        }

        return $this->redirectToRoute('store_cart_view');
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
     *      name = "store_coupon_remove",
     *      methods = {"GET"}
     * )
     */
    public function removeAction($code)
    {
        /**
         * @var CartInterface $cart
         */
        $cart = $this
            ->get('elcodi.wrapper.cart')
            ->get();

        $this
            ->get('elcodi.manager.cart_coupon')
            ->removeCouponByCode($cart, $code);

        return $this->redirectToRoute('store_cart_view');
    }
}
