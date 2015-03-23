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
 * @author Joan Galvan <joan.galvan@gmail.com>
 */

namespace Elcodi\Store\CartBundle\Controller;

use Mmoreram\ControllerExtraBundle\Annotation\Entity as AnnotationEntity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use Elcodi\Component\Cart\Entity\Interfaces\CartInterface;
use Elcodi\Component\Cart\Entity\Interfaces\CartLineInterface;
use Elcodi\Component\Product\Entity\Interfaces\ProductInterface;
use Elcodi\Store\CoreBundle\Controller\Traits\TemplateRenderTrait;

/**
 * Cart controller
 *
 * @Route(
 *      path = "/cart",
 * )
 */
class CartAjaxController extends Controller
{
    use TemplateRenderTrait;
    
    /**
     * Adds product into cart
     *
     * @param Request          $request Request object
     * @param ProductInterface $product Product id
     * @param CartInterface    $cart    Cart
     *
     * @return JsonResponse
     *
     * @throws \Exception
     *
     * @Route(
     *      path = "/product/{id}/add/ajax",
     *      name = "store_cart_add_product_ajax",
     *      requirements = {
     *          "id": "\d+"
     *      },
     *      methods = {"GET", "POST"}
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
     *          "factory" = "elcodi.wrapper.cart",
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
    ) {
        if (!$request->isXmlHttpRequest()) {
            throw new \Exception('Ajax route.');
        }

        $cartQuantity = (int) $request
            ->request
            ->get('add-cart-quantity', 1);

        $this
            ->get('elcodi.cart.manager')
            ->addProduct(
                $cart,
                $product,
                $cartQuantity
            );

        $response = new JsonResponse();
        $response->setData(array(
            'success' => true
        ));
        return $response;
    }

    /**
     * Removes product from cart
     *
     * @param Request          $request Request object
     * @param ProductInterface $product Product id
     * @param CartInterface    $cart    Cart
     *
     * @return JsonResponse
     *
     * @throws \Exception
     *
     * @Route(
     *      path = "/product/{id}/remove/ajax",
     *      name = "store_cart_remove_product_ajax",
     *      requirements = {
     *          "id": "\d+"
     *      },
     *      methods = {"GET", "POST"}
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
     *          "factory" = "elcodi.wrapper.cart",
     *          "method" = "loadCart",
     *          "static" = false,
     *      },
     *      name = "cart"
     * )
     */
    public function removeProductAction(
        Request $request,
        ProductInterface $product,
        CartInterface $cart
    ) {
        if (!$request->isXmlHttpRequest()) {
            throw new \Exception('Ajax route.');
        }

        $cartQuantity = (int) $request
            ->request
            ->get('add-cart-quantity', 1);

        $this
            ->get('elcodi.cart.manager')
            ->removeProduct(
                $cart,
                $product,
                $cartQuantity
            );

        $response = new JsonResponse();
        $response->setData(array(
            'success' => true
        ));
        return $response;
    }

    /**
     * Removes line from cart.
     *
     * @param Request          $request Request object
     * @param CartInterface     $cart     Cart
     * @param CartLineInterface $cartLine Cart Line
     *
     * @return JsonResponse
     *
     * @throws \Exception
     *
     * @Route(
     *      path = "/line/{id}/delete/ajax",
     *      name="store_cartline_remove_ajax",
     *      methods = {"GET"}
     * )
     *
     * @AnnotationEntity(
     *      class = {
     *          "factory" = "elcodi.wrapper.cart",
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
        Request $request,
        CartInterface $cart,
        CartLineInterface $cartLine
    ) {
        if (!$request->isXmlHttpRequest()) {
            throw new \Exception('Ajax route.');
        }

        $this
            ->get('elcodi.cart.manager')
            ->removeLine(
                $cart,
                $cartLine
            );

        $response = new JsonResponse();
        $response->setData(array(
            'success' => true
        ));
        return $response;
    }
}
