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

namespace Elcodi\AdminProductBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Elcodi\Component\Attribute\Entity\Attribute;
use Elcodi\Component\Attribute\Entity\Value;
use Mmoreram\ControllerExtraBundle\Annotation\Entity as EntityAnnotation;
use Mmoreram\ControllerExtraBundle\Annotation\Form as FormAnnotation;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

use Elcodi\AdminCoreBundle\Controller\Abstracts\AbstractAdminController;
use Elcodi\AdminCoreBundle\Controller\Interfaces\EnableableControllerInterface;
use Elcodi\AdminCoreBundle\Controller\Interfaces\NavegableControllerInterface;
use Elcodi\Component\Core\Entity\Abstracts\AbstractEntity;
use Elcodi\Component\Product\Entity\Product;
use Elcodi\Component\Product\Entity\Variant;

/**
 * Class Controller for Variant
 *
 * @Route(
 *      path = "/product/{id}/variant",
 *      requirements = {
 *          "id" = "\d*",
 *      }
 * )
 */
class VariantController
    extends
    AbstractAdminController
    implements
    NavegableControllerInterface,
    EnableableControllerInterface
{
    /**
     * Nav for product group
     *
     * @return array Result
     *
     * @Route(
     *      path = "s/nav",
     *      name = "admin_variant_nav"
     * )
     * @Method({"GET"})
     * @Template
     */
    public function navAction()
    {
        return [];
    }

    /**
     * List elements of certain entity type.
     *
     * This action is just a wrapper, so should never get any data,
     * as this is component responsability
     *
     * @param Request $request          Request
     * @param integer $page             Page
     * @param integer $limit            Limit of items per page
     * @param string  $orderByField     Field to order by
     * @param string  $orderByDirection Direction to order by
     *
     * @return array Result
     *
     * @Route(
     *      path = "s/list/{page}/{limit}/{orderByField}/{orderByDirection}",
     *      name = "admin_variant_list",
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
     * )
     * @Template
     * @Method({"GET"})
     */
    public function listAction(
        Request $request,
        $page,
        $limit,
        $orderByField,
        $orderByDirection
    )
    {
        return [
            'page'             => $page,
            'limit'            => $limit,
            'orderByField'     => $orderByField,
            'orderByDirection' => $orderByDirection,
        ];
    }

    /**
     * View element action.
     *
     * This action is just a wrapper, so should never get any data,
     * as this is component responsability
     *
     * @param Request $request   Request
     * @param integer $id        Product id
     * @param integer $variantId Variant id
     *
     * @return array Result
     *
     * @Route(
     *      path = "/{variantId}",
     *      name = "admin_variant_view",
     *      requirements = {
     *          "variantId" = "\d*",
     *      }
     * )
     * @Template("@AdminProduct/Variant/view.html.twig")
     * @Method({"GET"})
     */
    public function viewAction(
        Request $request,
        $id,
        $variantId
    )
    {
        return [
            'id' => $id,
            'variantId' => $variantId
        ];
    }

    /**
     * New element action
     *
     * This action is just a wrapper, so should never get any data,
     * as this is component responsability
     *
     * @param $id integer Product id
     * @return array Result
     *
     * @Route(
     *      path = "/new",
     *      name = "admin_variant_new"
     * )
     * @Template
     * @Method({"GET"})
     */
    public function newAction($id)
    {
        return [
            'id' => $id
        ];
    }

    /**
     * Save new element action
     *
     * Should be POST
     *
     * @param Request        $request Request
     * @param Variant        $variant Product variant Entity to save
     * @param Product        $product Parent product for the variant being saved
     * @param FormInterface  $form    Form view
     * @param boolean        $isValid Request handle is valid
     *
     * @return RedirectResponse Redirect response
     *
     * @Route(
     *      path = "/save",
     *      name = "admin_variant_save"
     * )
     * @Method({"POST"})
     *
     * @EntityAnnotation(
     *     class = "elcodi.core.product.entity.product.class",
     *     mapping = {
     *         "id": "~id~"
     *     },
     *     name = "product"
     * )
     * @EntityAnnotation(
     *     class = {
     *         "factory" = "elcodi.core.product.factory.variant"
     *     },
     *     name = "variant",
     *     persist = true,
     *     setters = {
     *         "setProduct": "product"
     *     }
     * )
     * @FormAnnotation(
     *      class = "elcodi_admin_product_form_type_variant",
     *      name  = "form",
     *      entity = "variant",
     *      handleRequest = true,
     *      validate = "isValid"
     * )
     */
    public function saveAction(
        Request $request,
        Variant $variant,
        Product $product,
        FormInterface $form,
        $isValid
    )
    {
        /**
         * @var Variant $entity
         */
        $variant->setProduct($product);

        $this
            ->getManagerForClass($variant)
            ->flush($variant);

        /**
         * @var Value $option
         */
        foreach ($variant->getOptions() as $option) {
            /*
             * When adding an option to a Variant it is
             * important to check that the parent Product
             * has its corresponding Attribute
             */
            if (!$product->getAttributes()->contains($option->getAttribute())) {
                $product->addAttribute($option->getAttribute());
            }
        }

        $this
            ->getManagerForClass($product)
            ->flush();

        return $this->redirectRoute("admin_variant_view", [
            'id' => $product->getId(),
            'variantId' => $variant->getId()
        ]);
    }

    /**
     * Edit element action
     *
     * This action is just a wrapper, so should never get any data,
     * as this is component responsability
     *
     * @param  Request $request   Request
     * @param  integer $id        Product id
     * @param  integer $variantId Variant id
     * @return array   Result
     *
     * @Route(
     *      path = "/{variantId}/edit",
     *      name = "admin_variant_edit"
     * )
     * @Template
     * @Method({"GET"})
     */
    public function editAction(
        Request $request,
        $id,
        $variantId
    )
    {
        return [
            'id' => $id,
            'variantId' => $variantId,
        ];
    }

    /**
     * Updated edited element action
     *
     * Should be POST
     *
     * @param Request        $request Request
     * @param Variant        $variant Product variant to update
     * @param FormInterface  $form    Form view
     * @param boolean        $isValid Request handle is valid
     *
     * @return RedirectResponse Redirect response
     *
     * @Route(
     *      path = "/{variantId}/update",
     *      name = "admin_variant_update"
     * )
     * @Method({"POST"})
     *
     * @EntityAnnotation(
     *      class = "elcodi.core.product.entity.variant.class",
     *      name = "variant",
     *      mapping = {
     *          "id": "~variantId~",
     *      }
     * )
     * @FormAnnotation(
     *      class = "elcodi_admin_product_form_type_variant",
     *      name  = "form",
     *      entity = "variant",
     *      handleRequest = true,
     *      validate = "isValid"
     * )
     */
    public function updateAction(
        Request $request,
        Variant $variant,
        FormInterface $form,
        $isValid
    )
    {

        $this
            ->getManagerForClass($variant)
            ->flush($variant);

        /**
         * @var Product $product
         */
        $product = $variant->getProduct();

        /**
         * @var Value $option
         */
        foreach ($variant->getOptions() as $option) {
            /*
             * When adding an option to a Variant it is
             * important to check that the parent Product
             * has its corresponding Attribute
             */
            if (!$product->getAttributes()->contains($option->getAttribute())) {
                $product->addAttribute($option->getAttribute());
            }
        }

        $this
            ->getManagerForClass($product)
            ->flush();

        return $this->redirectRoute("admin_variant_view", [
            'id'        => $variant->getProduct()->getId(),
            'variantId' => $variant->getId(),
        ]);
    }

    /**
     * Enable entity
     *
     * @param Request        $request Request
     * @param AbstractEntity $variant Product variant to enable
     *
     * @return array Result
     *
     * @Route(
     *      path = "/{variantId}/enable",
     *      name = "admin_variant_enable"
     * )
     * @Method({"GET", "POST"})
     *
     * @EntityAnnotation(
     *      class = "elcodi.core.product.entity.variant.class",
     *      name = "variant",
     *      mapping = {
     *          "id" = "~variantId~"
     *      }
     * )
     */
    public function enableAction(
        Request $request,
        AbstractEntity $variant
    )
    {
        return parent::enableAction(
            $request,
            $variant
        );
    }

    /**
     * Disable entity
     *
     * @param Request        $request Request
     * @param AbstractEntity $entity  Entity to disable
     *
     * @return array Result
     *
     * @Route(
     *      path = "/{variantId}/disable",
     *      name = "admin_variant_disable"
     * )
     * @Method({"GET", "POST"})
     *
     * @EntityAnnotation(
     *      class = "elcodi.core.product.entity.variant.class",
     *      mapping = {
     *          "id" = "~variantId~"
     *      }
     * )
     */
    public function disableAction(
        Request $request,
        AbstractEntity $entity
    )
    {
        return parent::disableAction(
            $request,
            $entity
        );
    }

    /**
     * Delete element action
     *
     * @param Request        $request     Request
     * @param AbstractEntity $variant     Variant to delete
     * @param string         $redirectUrl Redirect url
     *
     * @return RedirectResponse Redirect response
     *
     * @Route(
     *      path = "/{variantId}/delete",
     *      name = "admin_variant_delete"
     * )
     * @Method({"GET", "POST"})
     *
     * @EntityAnnotation(
     *     class = "elcodi.core.product.entity.product.class",
     *     name = "product",
     *     mapping = {
     *         "id": "~id~"
     *     }
     * )
     * @EntityAnnotation(
     *      class = "elcodi.core.product.entity.variant.class",
     *      name = "variant",
     *      mapping = {
     *          "id" = "~variantId~"
     *      }
     * )
     */
    public function deleteAction(
        Request $request,
        AbstractEntity $variant,
        $redirectUrl = null
    )
    {
        /**
         * @var Product $product
         * @var Variant $variant
         */
        $product = $variant->getProduct();

        /*
         * Getting the list of unique Attributes associated with
         * the Variant to be deleted. This is a safety check,
         * since a Variant should *not* have more than one
         * option with the same Attribute
         */
        $variantAttributes = $this->getUniqueAttributesFromVariant($variant);;

        $notRemovableAttributes = [];

        /**
         * @var Variant $iteratedVariant
         *
         * Getting all the Attributes by iterating over the parent
         * product Variants (except for the Variant being deleted)
         * to see if we can safetly remove from the product collection
         * the Attributes associated with the Variant to be removed
         *
         */
        foreach ($product->getVariants() as $iteratedVariant) {

            /*
             * We want to collect Attributes from Varints other
             * than the one we want to delete
             */
            if ($iteratedVariant == $variant) {
                /*
                 * Do not add attributes from Variant to be deleted
                 */
                continue;
            }

            $notRemovableAttributes = array_merge(
                $notRemovableAttributes,
                $this->getUniqueAttributesFromVariant($iteratedVariant)
            );

        }

        /**
         * @var Attribute $variantAttribute
         *
         * Checking whether we can safely de-associate
         * Attributes from the Variant we are deleting
         * from parent product Attribute collection
         */
        foreach ($variantAttributes as $variantAttribute) {

            if (in_array($variantAttribute, $notRemovableAttributes)) {
                continue;
            }

            $product->removeAttribute($variantAttribute);
        }

        $this
            ->getManagerForClass($product)
            ->flush();

        return parent::deleteAction(
            $request,
            $variant,
            function () use ($product) {
                return $this->generateUrl('admin_product_view', [
                    'id' => $product->getId(),
                ]);
            }
        );
    }

    /**
     * Given a Variant, return a list of the associated Attributes
     *
     * The Attribute is fetched from the "options" relation. In theory
     * each option in a Variant should belong to a different Attribute.
     *
     * @param Variant $variant
     *
     * @return array
     */
    private function getUniqueAttributesFromVariant(Variant $variant)
    {
        $variantAttributes = [];

        foreach ($variant->getOptions() as $option) {

            /**
             * @var Attribute $attribute
             */
            $attribute = $option->getAttribute();

            if (!array_key_exists($attribute->getId(), $variantAttributes)) {
                $variantAttributes[$attribute->getId()] = $attribute;
            }
        }

        return $variantAttributes;
    }


}
