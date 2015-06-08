<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2015 Elcodi.com
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

namespace Elcodi\Store\CartBundle\Controller;

use Doctrine\ORM\EntityNotFoundException;
use Mmoreram\ControllerExtraBundle\Annotation\Entity as AnnotationEntity;
use Mmoreram\ControllerExtraBundle\Annotation\Form as AnnotationForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Elcodi\Component\Cart\Entity\Interfaces\CartInterface;
use Elcodi\Component\Cart\Entity\Interfaces\CartLineInterface;
use Elcodi\Component\Product\Entity\Interfaces\ProductInterface;
use Elcodi\Component\Product\Entity\Interfaces\VariantInterface;
use Elcodi\Store\CoreBundle\Controller\Traits\TemplateRenderTrait;

/**
 * Cart controllers
 *
 * @Route(
 *      path = "/cart",
 * )
 */
class CartController extends Controller
{
    use TemplateRenderTrait;

    /**
     * Cart view
     *
     * @param FormView      $formView Form view
     * @param CartInterface $cart     Cart
     *
     * @return Response Response
     *
     * @Route(
     *      path = "",
     *      name = "store_cart_view",
     *      methods = {"GET"}
     * )
     *
     * @AnnotationEntity(
     *      class = {
     *          "factory" = "elcodi.wrapper.cart",
     *          "method" = "get",
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
    ) {
        $relatedProducts = [];

        if ($cart->getCartLines()->count()) {
            $relatedProducts = $this
                ->get('elcodi_store.provider.product_collection')
                ->getRelatedProducts($cart
                    ->getCartLines()
                    ->first()
                    ->getProduct(), 3);
        }

        $cartCoupons = $this
            ->get('elcodi.manager.cart_coupon')
            ->getCartCoupons($cart);

        return $this->renderTemplate(
            'Pages:cart-view.html.twig',
            [
                'cart'             => $cart,
                'cartCoupons'      => $cartCoupons,
                'form'             => $formView,
                'related_products' => $relatedProducts,
            ]
        );
    }

    /**
     * Adds product into cart
     *
     * @param Request          $request Request object
     * @param ProductInterface $product Product id
     * @param CartInterface    $cart    Cart
     *
     * @return Response Redirect response
     *
     * @throws EntityNotFoundException product not found
     *
     * @Route(
     *      path = "/product/{id}/add",
     *      name = "store_cart_add_product",
     *      requirements = {
     *          "id": "\d+"
     *      },
     *      methods = {"GET", "POST"}
     * )
     *
     * @AnnotationEntity(
     *      class = "elcodi.entity.product.class",
     *      name = "product",
     *      mapping = {
     *          "id" = "~id~",
     *          "enabled" = true,
     *      }
     * )
     * @AnnotationEntity(
     *      class = {
     *          "factory" = "elcodi.wrapper.cart",
     *          "method" = "get",
     *          "static" = false,
     *      },
     *      name = "cart"
     * )
     */
    public function addProductAction(
        Request $request,
        ProductInterface $product,
        CartInterface $cart
    ) {
        $cartQuantity = (int) $request
            ->request
            ->get('add-cart-quantity', 1);

        $this
            ->get('elcodi.manager.cart')
            ->addProduct(
                $cart,
                $product,
                $cartQuantity
            );

        return $this->redirect(
            $this->generateUrl('store_cart_view')
        );
    }

    /**
     * Adds product variant into cart
     *
     * @param Request          $request Request object
     * @param VariantInterface $variant variant
     * @param CartInterface    $cart    Cart
     *
     * @return Response Redirect response
     *
     * @throws EntityNotFoundException product not found
     *
     * @Route(
     *      path = "/product/variant/{id}/add",
     *      name = "store_cart_add_product_variant",
     *      requirements = {
     *          "id": "\d+"
     *      },
     *      methods = {"GET", "POST"}
     * )
     *
     * @AnnotationEntity(
     *      class = "elcodi.entity.product_variant.class",
     *      name = "variant",
     *      mapping = {
     *          "id" = "~id~",
     *          "enabled" = true,
     *      }
     * )
     * @AnnotationEntity(
     *      class = {
     *          "factory" = "elcodi.wrapper.cart",
     *          "method" = "get",
     *          "static" = false,
     *      },
     *      name = "cart"
     * )
     */
    public function addVariantAction(
        Request $request,
        VariantInterface $variant,
        CartInterface $cart
    ) {
        $cartQuantity = (int) $request
            ->request
            ->get('add-cart-quantity', 1);

        $this
            ->get('elcodi.manager.cart')
            ->addProduct(
                $cart,
                $variant,
                $cartQuantity
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
     *      name="store_cart_empty",
     *      methods = {"GET"}
     * )
     *
     * @AnnotationEntity(
     *      class = {
     *          "factory" = "elcodi.wrapper.cart",
     *          "method" = "get",
     *          "static" = false,
     *      },
     *      name = "cart"
     * )
     */
    public function emptyCartAction(CartInterface $cart)
    {
        $this
            ->get('elcodi.manager.cart')
            ->emptyLines($cart);

        return $this->redirect(
            $this->generateUrl('store_homepage')
        );
    }

    /**
     * Update Cart
     *
     * @param FormInterface $form    Form
     * @param CartInterface $cart    Cart
     * @param boolean       $isValid Form is valid
     *
     * @return RedirectResponse
     *
     * @Route(
     *      path = "/update",
     *      name="store_cart_update",
     *      methods = {"POST"}
     * )
     *
     * @AnnotationEntity(
     *      class = {
     *          "factory" = "elcodi.wrapper.cart",
     *          "method" = "get",
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
    ) {
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
     *      name="store_cartline_remove",
     *      methods = {"GET"}
     * )
     *
     * @AnnotationEntity(
     *      class = {
     *          "factory" = "elcodi.wrapper.cart",
     *          "method" = "get",
     *          "static" = false,
     *      },
     *      name = "cart"
     * )
     * @AnnotationEntity(
     *      class = "elcodi.entity.cart_line.class",
     *      name = "cartLine",
     *      mapping = {
     *          "id" = "~id~",
     *      }
     * )
     */
    public function removeCartLineAction(
        CartInterface $cart,
        CartLineInterface $cartLine
    ) {
        $this
            ->get('elcodi.manager.cart')
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
     * @return Response Response
     *
     * @Route(
     *      path = "/nav",
     *      name = "store_cart_nav",
     *      methods = {"GET"}
     * )
     *
     * @AnnotationEntity(
     *      class = {
     *          "factory" = "elcodi.wrapper.cart",
     *          "method" = "get",
     *          "static" = false,
     *      },
     *      name = "cart"
     * )
     */
    public function navAction(CartInterface $cart)
    {
        return $this->renderTemplate(
            'Subpages:cart-nav.html.twig',
            [
                'cart' => $cart,
            ]
        );
    }
}
