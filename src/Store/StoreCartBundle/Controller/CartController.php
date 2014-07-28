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

namespace Store\StoreCartBundle\Controller;

use Elcodi\ProductBundle\Entity\Interfaces\VariantInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Mmoreram\ControllerExtraBundle\Annotation\Form as AnnotationForm;
use Mmoreram\ControllerExtraBundle\Annotation\Entity as AnnotationEntity;

use Elcodi\ProductBundle\Entity\Interfaces\ProductInterface;
use Elcodi\CartBundle\Entity\Interfaces\CartLineInterface;
use Elcodi\CartBundle\Entity\Interfaces\CartInterface;

/**
 * Cart controllers
 *
 * @Route(
 *      path = "/cart",
 * )
 */
class CartController extends Controller
{
    /**
     * Cart view
     *
     * @param FormView      $formView Form view
     * @param CartInterface $cart     Cart
     *
     * @return array
     *
     * @Route(
     *      path = "",
     *      name = "store_cart_view"
     * )
     * @Method("GET")
     * @Template
     *
     * @AnnotationEntity(
     *      class = {
     *          "factory" = "elcodi.cart_wrapper",
     *          "method" = "loadCart",
     *          "static" = false,
     *      },
     *      name = "cart"
     * )
     * @AnnotationForm(
     *      class = "store_cart_form_type_cart",
     *      name  = "formView",
     *      entity = "cart",
     * )
     */
    public function viewAction(
        FormView $formView,
        CartInterface $cart
    )
    {
        $relatedProducts = [];

        if ($cart->getCartLines()->count()) {

            $relatedProducts = $this
                ->get('store.product.service.product_collection_provider')
                ->getRelatedProducts($cart
                        ->getCartLines()
                        ->first()
                        ->getProduct()
                    , 3);
        }

        $cartCoupons = $this
            ->get('elcodi.cart_coupon_manager')
            ->getCartCoupons($cart);

        return [
            'cart'             => $cart,
            'cartcoupon'       => $cartCoupons,
            'form'             => $formView,
            'related_products' => $relatedProducts
        ];
    }

    /**
     * Adds item into cart
     *
     * @param Request          $request Request object
     * @param ProductInterface $product Product id
     * @param CartInterface    $cart    Cart
     *
     * @return Response Redirect response
     *
     * @Route(
     *      path = "/product/{id}/add",
     *      name = "store_cart_add_product",
     *      requirements = {
     *          "productId": "\d+"
     *      }
     * )
     *
     * @AnnotationEntity(
     *      class = "elcodi.core.product.entity.product.class",
     *      name = "product",
     *      mapping = {
     *          "id" = "~id~",
     *          "enabled" = true,
     *      }
     * )
     * @AnnotationEntity(
     *      class = {
     *          "factory" = "elcodi.cart_wrapper",
     *          "method" = "loadCart",
     *          "static" = false,
     *      },
     *      name = "cart"
     * )
     */
    public function addProductAction(
        Request $request,
        ProductInterface $product,
        CartInterface $cart
    )
    {
        if ($request->request->get('add-cart-is-variant')) {
            /**
             * We are adding a Product with variant,
             * we should identify the Variant given
             * the submitted attribute/options
             */
            $optionIds = $request->request->get('variant-option-for-attribute');

            $purchasable = $this
                ->get('elcodi.repository.variant')
                ->findByOptionIds($product, $optionIds);

            if (!($purchasable instanceof VariantInterface)) {

                throw new EntityNotFoundException($this
                    ->container
                    ->getParameter('elcodi.core.product.entity.variant.class'));
            }

        } else {
            /**
             * There is no variant, add the Product as is
             */
            $purchasable = $product;
        }

        $cart = $this
            ->get('elcodi.cart_wrapper')
            ->loadCart();

        $this
            ->get('elcodi.cart_manager')
            ->addProduct(
                $cart,
                $purchasable,
                (int) $request->request->get('add-cart-quantity', 1)
            );

        return $this->redirect(
            $this->generateUrl('store_cart_view')
        );
    }

    /**
     * Empty Cart
     *
     * @param CartInterface $cart Cart
     *
     * @return RedirectResponse
     *
     * @Route(
     *      path = "/empty",
     *      name="store_cart_empty"
     * )
     *
     * @AnnotationEntity(
     *      class = {
     *          "factory" = "elcodi.cart_wrapper",
     *          "method" = "loadCart",
     *          "static" = false,
     *      },
     *      name = "cart"
     * )
     */
    public function emptyCartAction(CartInterface $cart)
    {
        $this
            ->get('elcodi.cart_manager')
            ->emptyLines($cart);

        return $this->redirect(
            $this->generateUrl('store_homepage')
        );
    }

    /**
     * Empty Cart
     *
     * @param FormInterface $form    Form
     * @param CartInterface $cart    Cart
     * @param boolean       $isValid Form is valid
     *
     * @return RedirectResponse
     *
     * @Route(
     *      path = "/update",
     *      name="store_cart_update"
     * )
     * @Method({"POST"})
     *
     * @AnnotationEntity(
     *      class = {
     *          "factory" = "elcodi.cart_wrapper",
     *          "method" = "loadCart",
     *          "static" = false,
     *      },
     *      name = "cart"
     * )
     * @AnnotationForm(
     *      class = "store_cart_form_type_cart",
     *      entity = "cart",
     *      handleRequest = true,
     *      validate = "isValid",
     * )
     */
    public function updateCartAction(
        FormInterface $form,
        CartInterface $cart,
        $isValid
    )
    {
        if ($isValid) {

            $this
                ->get('elcodi.object_manager.cart')
                ->flush();
        }

        return $this->redirect(
            $this->generateUrl('store_cart_view')
        );
    }

    /**
     * Deletes CartLine
     *
     * @param CartInterface     $cart     Cart
     * @param CartLineInterface $cartLine Cart Line
     *
     * @return RedirectResponse
     *
     * @Route(
     *      path = "/line/{id}/delete",
     *      name="store_cartline_remove"
     * )
     *
     * @AnnotationEntity(
     *      class = {
     *          "factory" = "elcodi.cart_wrapper",
     *          "method" = "loadCart",
     *          "static" = false,
     *      },
     *      name = "cart"
     * )
     * @AnnotationEntity(
     *      class = "elcodi.core.cart.entity.cart_line.class",
     *      name = "cartLine",
     *      mapping = {
     *          "id" = "~id~",
     *      }
     * )
     */
    public function removeCartLineAction(
        CartInterface $cart,
        CartLineInterface $cartLine
    )
    {
        $this
            ->get('elcodi.cart_manager')
            ->removeLine(
                $cart,
                $cartLine
            );

        return $this->redirect(
            $this->generateUrl('store_cart_view')
        );
    }

    /**
     * reduced version of cart
     *
     * @param CartInterface $cart Cart
     *
     * @return array Result
     *
     * @Route(
     *      path = "/nav",
     *      name = "store_cart_nav"
     * )
     * @Template
     *
     * @AnnotationEntity(
     *      class = {
     *          "factory" = "elcodi.cart_wrapper",
     *          "method" = "loadCart",
     *          "static" = false,
     *      },
     *      name = "cart"
     * )
     */
    public function navAction(CartInterface $cart)
    {
        return [
            'cart' => $cart,
        ];
    }
}
