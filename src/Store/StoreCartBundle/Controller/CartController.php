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

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Doctrine\ORM\EntityNotFoundException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use Elcodi\CartBundle\Entity\Cart;
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
        return [
            'cart' => $this->loadCart(),
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
     *      name = "cart_add_product"
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

        } catch (\Exception $e) {
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
     * @param Request $request  Request
     * @param Boolean $checkout Go to checkout page
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
    public function emptyCartAction(Request $request, $checkout)
    {
        /** @var Cart $cart */
        $cartId = $this->get('session')->get($this->container->getParameter('elcodi.core.cart.session_field_name'));
        $cart = $cartId ?
            $this->getDoctrine()->getRepository('ElcodiCartBundle:Cart')->find($cartId) :
            $this->get('elcodi.core.cart.factory.cart')->create();

        $this
            ->get('elcodi.core.cart.service.cart_manager')
            ->emptyLines($cart);


        return $this->doRedirection($checkout, $request);
    }

    /**
     * Sets CartLine quantity value
     *
     * @param Request $request
     * @param int     $cartLineId CartLine id
     * @param Boolean $checkout   Go to checkout page
     *
     * @return Response Redirect response
     *
     * @Route(
     *      path = "/line/{cartlineId}/quantity/set",
     *      name="cartline_set_quantity",
     *      defaults = {
     *          "checkout": false
     *      }
     * )
     * @Route(
     *      path = "/line/{cartlineId}/quantity/set/checkout",
     *      name="cartline_set_quantity_checkout",
     *      defaults = {
     *          "checkout": true
     *      }
     * )
     */
    public function setcartLineQuantityAction(Request $request, $checkout, $cartLineId = null)
    {
        $trans = $this->get('translator');

        $cartLine = $this->getDoctrine()->getRepository('ElcodiCartBundle:CartLine')->find($cartLineId);

        if (is_null($cartLine)) {

            if (is_null($cartLine)) {
                //if CartLine was not found...
                $this->get('session')->getFlashBag()->add('error', $trans->trans('_Product_add_error'));

                return $this->doRedirection($checkout, $request);
            }
        }
        $quantity = $request->get('quantity', 1);

        try {

            $this
                ->get('elcodi.core.cart.service.cart_manager')
                ->setCartLineQuantity($cartLine, $quantity);

        } catch (\Exception $e) {

            $this
                ->get('session')
                ->getFlashBag()
                ->add('error', $trans->trans('_Product_add_error'));
        }

        return $this->doRedirection($checkout, $request);
    }

    /**
     * Deletes CartLine
     *
     * @param Request $request    Request
     * @param int     $cartLineId CartLine id
     * @param Boolean $checkout   Go to checkout page
     *
     * @return RedirectResponse
     *
     * @Route(
     *      path = "/line/{cartLineId}/delete",
     *      name="cartline_remove",
     *      defaults = {
     *          "checkout": false
     *      }
     * )
     * @Route(
     *      path = "/line/{cartLineId}/delete/checkout",
     *      name = "cartline_remove_checkout",
     *      defaults={
     *          "checkout": true
     *      }
     * )
     *
     */
    public function removeCartLineAction(Request $request, $checkout, $cartLineId = null)
    {
        $cartLine = $this->getDoctrine()->getRepository('ElcodiCartBundle:CartLine')->find($cartLineId);

        if (is_null($cartLine)) {
            //if CartLine was not found...
            $this->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('_Product_add_error'));

            return $this->doRedirection($checkout, $request);
        }

        /** @var Cart $cart */
        $customer = $this->get('elcodi.core.user.wrapper.customer_wrapper')->getCustomer();
        $cart = $this->get('elcodi.core.cart.service.cart_manager')->loadCustomerCart($customer);

        $this
            ->get('elcodi.core.cart.service.cart_manager')
            ->removeLine($cart, $cartLine);

        return $this->doRedirection($checkout, $request);
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
        $cartId = $this->get('session')->get($this->container->getParameter('elcodi.core.cart.session_field_name'));
        $cart = $cartId ?
            $this->getDoctrine()->getRepository('ElcodiCartBundle:Cart')->find($cartId) :
            $this->get('elcodi.core.cart.factory.cart')->create();

        return array(
            'cart' => $cart
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
        /**
         * @var CartInterface $cart
         */
        $cartId = $this
            ->get('session')
            ->get($this
                    ->container
                    ->getParameter('elcodi.core.cart.session_field_name')
            );

        if ($cartId) {

            $cart = $this
                ->get('elcodi.repository_provider')
                ->getRepositoryByEntityParameter('elcodi.core.cart.entity.cart.class')
                ->find($cartId);
        } else {

            $cart = $this->get('elcodi.core.cart.service.cart_manager')->loadCart(
                $this->get('elcodi.core.cart.factory.cart')->create()
            );

        }

        return $cart;
    }
}
