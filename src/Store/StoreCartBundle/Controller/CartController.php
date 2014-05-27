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
 * @author  ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Store\StoreCartBundle\Controller;

use Elcodi\CartBundle\Entity\Interfaces\CartLineInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Doctrine\ORM\EntityNotFoundException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Exception;

use Elcodi\CartBundle\Entity\Interfaces\CartInterface;
use Elcodi\CartBundle\Exception\CartLineOutOfStockException;
use Elcodi\CartBundle\Exception\CartLineProductUnavailableException;
use Elcodi\ProductBundle\Entity\Interfaces\ProductInterface;

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
     * @return array
     *
     * @Route(
     *      path = "",
     *      name = "store_cart_view"
     * )
     * @Method("GET")
     * @Template
     */
    public function viewAction()
    {
        $relatedProducts = [];
        $cart = $this->loadCart();

        if ($cart->getCartLines()->count()) {

            $relatedProducts = $this
                ->get('store.product.service.product_collection_provider')
                ->getRelatedProducts($cart
                        ->getCartLines()
                        ->first()
                        ->getProduct()
                    , 3);
        }

        return [
            'cart'             => $cart,
            'related_products' => $relatedProducts
        ];
    }

    /**
     * Adds item into cart
     *
     * @param Request $request   Request object
     * @param int     $productId Product id
     *
     * @return Response Redirect response
     *
     * @Route(
     *      path = "/product/{productId}/add",
     *      name = "cart_add_product",
     *      requirements = {
     *          "productId": "\d+"
     *      }
     * )
     *
     * @throws EntityNotFoundException Product not found
     */
    public function addProductAction(Request $request, $productId)
    {
        $product = $this
            ->get('elcodi.repository_provider')
            ->getRepositoryByEntityParameter('elcodi.core.product.entity.product.class')
            ->find($productId);

        if (!($product instanceof ProductInterface)) {

            throw new EntityNotFoundException($this
                ->container
                ->getParameter('elcodi.core.product.entity.product.class'));
        }

        $quantity = $request->get('quantity', 1);
        if (intval($quantity) < 1) {
            $quantity = 1;
        }

        $cart = $this->loadCart();

        try {

            $this
                ->get('elcodi.core.cart.service.cart_manager')
                ->addProduct($cart, $product, $quantity);

            $this
                ->get('elcodi.manager_provider')
                ->getManagerByEntityParameter('elcodi.core.cart.entity.cart.class')
                ->flush();

        } catch (CartLineProductUnavailableException $e) {

            $this
                ->get('session')
                ->getFlashBag()
                ->add('error', 'This product is currently unavailable');

        } catch (CartLineOutOfStockException $e) {

            $this
                ->get('session')
                ->getFlashBag()
                ->add('error', 'This product is out of stock');

        } catch (Exception $e) {

            $this
                ->get('session')
                ->getFlashBag()
                ->add('error', 'A problem ocurred when adding to cart');
        }

        return $this->redirect($this->generateUrl('store_cart_view'));
    }

    /**
     * Empty Cart
     *
     * @return RedirectResponse
     *
     * @Route(
     *      path = "/empty",
     *      name="cart_empty",
     *      defaults = {
     *          "checkout": false
     *      }
     * )
     * @Route(
     *      path = "/empty/checkout",
     *      name = "cart_empty_checkout",
     *      defaults={
     *          "checkout": true
     *      }
     * )
     */
    public function emptyCartAction()
    {
        $this
            ->get('elcodi.core.cart.service.cart_manager')
            ->emptyLines($this->loadCart());

        return $this->redirect($this->generateUrl('store_homepage'));
    }

    /**
     * Deletes CartLine
     *
     * @param int $cartLineId CartLine id
     *
     * @return RedirectResponse
     *
     * @Route(
     *      path = "/line/{cartLineId}/delete",
     *      name="cartline_remove"
     * )
     *
     * @throws EntityNotFoundException CartLine not found
     */
    public function removeCartLineAction($cartLineId)
    {
        $cartLine = $this
            ->get('elcodi.repository.cart_line')
            ->find($cartLineId);

        if (!($cartLine instanceof CartLineInterface)) {

            throw new EntityNotFoundException($this
                ->container
                ->getParameter('elcodi.core.cart.entity.cart_line.class'));
        }

        $this
            ->get('elcodi.core.cart.service.cart_manager')
            ->removeLine($this->loadCart(), $cartLine);

        return $this->redirect($this->generateUrl('store_cart_view'));
    }

    /**
     * reduced version of cart
     *
     * @return array Result
     *
     * @Route(
     *      path = "/nav",
     *      name = "store_cart_nav"
     * )
     *
     * @Template
     */
    public function navAction()
    {
        return array(
            'cart' => $this->loadCart(),
        );
    }

    /**
     * Get cart from session.
     *
     * If none is found, create a new one
     *
     * @return CartInterface Cart
     */
    public function loadCart()
    {
        return $this
            ->get('elcodi.cart_wrapper')
            ->loadCart();
    }
}
