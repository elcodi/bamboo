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

namespace Elcodi\Admin\ProductBundle\Controller;

use Mmoreram\ControllerExtraBundle\Annotation\Entity as EntityAnnotation;
use Mmoreram\ControllerExtraBundle\Annotation\Form as FormAnnotation;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

use Elcodi\Admin\CoreBundle\Controller\Abstracts\AbstractAdminController;
use Elcodi\Component\Attribute\Entity\Interfaces\AttributeInterface;
use Elcodi\Component\Attribute\Entity\Interfaces\ValueInterface;
use Elcodi\Component\Core\Entity\Interfaces\EnabledInterface;
use Elcodi\Component\Media\Entity\Interfaces\ImageInterface;
use Elcodi\Component\Product\Entity\Interfaces\ProductInterface;
use Elcodi\Component\Product\Entity\Interfaces\VariantInterface;

/**
 * Class Controller for Variant
 *
 * @Route(
 *      path = "/product/{productId}/variant",
 *      requirements = {
 *          "productId" = "\d+",
 *      }
 * )
 */
class VariantController extends AbstractAdminController
{
    /**
     * Edit and Saves product
     *
     * @param FormInterface    $form    Form
     * @param ProductInterface $product Product
     * @param VariantInterface $variant Variant
     * @param boolean          $isValid Is valid
     *
     * @return RedirectResponse Redirect response
     *
     * @Route(
     *      path = "/{id}",
     *      name = "admin_product_variant_edit",
     *      requirements = {
     *          "id" = "\d+",
     *      },
     *      methods = {"GET"}
     * )
     * @Route(
     *      path = "/{id}/update",
     *      name = "admin_product_variant_update",
     *      requirements = {
     *          "id" = "\d+",
     *      },
     *      methods = {"POST"}
     * )
     *
     * @Route(
     *      path = "/new",
     *      name = "admin_product_variant_new",
     *      methods = {"GET"}
     * )
     * @Route(
     *      path = "/new/update",
     *      name = "admin_product_variant_save",
     *      methods = {"POST"}
     * )
     *
     * @EntityAnnotation(
     *      class = {
     *          "factory" = "elcodi.factory.product",
     *          "method" = "create",
     *          "static" = false
     *      },
     *      mapping = {
     *          "id" = "~productId~"
     *      },
     *      name = "product"
     * )
     * @EntityAnnotation(
     *      class = {
     *          "factory" = "elcodi.factory.product_variant",
     *          "method" = "create",
     *          "static" = false
     *      },
     *      mapping = {
     *          "id" = "~id~"
     *      },
     *      mappingFallback = true,
     *      name = "variant",
     *      persist = true
     * )
     * @FormAnnotation(
     *      class = "elcodi_admin_product_form_type_product_variant",
     *      name  = "form",
     *      entity = "variant",
     *      handleRequest = true,
     *      validate = "isValid"
     * )
     *
     * @Template
     */
    public function editAction(
        FormInterface $form,
        ProductInterface $product,
        VariantInterface $variant,
        $isValid
    ) {
        if ($isValid) {
            $firstImage = $variant
                ->getSortedImages()
                ->first();

            if ($firstImage instanceof ImageInterface) {
                $variant->setPrincipalImage($firstImage);
            }

            /**
             * @var VariantInterface $entity
             */
            $variant->setProduct($product);

            /**
             * @var ValueInterface $option
             */
            foreach ($variant->getOptions() as $option) {

                /**
                 * When adding an option to a Variant it is
                 * important to check that the parent Product
                 * has its corresponding Attribute
                 */
                $optionAttribute = $option->getAttribute();

                if (!$product
                    ->getAttributes()
                    ->contains($optionAttribute)
                ) {
                    $product->addAttribute($optionAttribute);
                }
            }

            $this->flush($variant);
            $this->flush($product);

            $this->addFlash('success', 'admin.variant.saved');

            return $this->redirectToRoute('admin_product_edit', [
                'id'        => $product->getId(),
            ]);
        }

        return [
            'product' => $product,
            'variant' => $variant,
            'form'    => $form->createView(),
        ];
    }

    /**
     * Enable entity
     *
     * @param Request          $request Request
     * @param EnabledInterface $variant Product variant to enable
     *
     * @return array Result
     *
     * @Route(
     *      path = "/{variantId}/enable",
     *      name = "admin_product_variant_enable"
     * )
     * @Method({"GET", "POST"})
     *
     * @EntityAnnotation(
     *      class = "elcodi.entity.product_variant.class",
     *      name = "variant",
     *      mapping = {
     *          "id" = "~variantId~"
     *      }
     * )
     */
    public function enableAction(
        Request $request,
        EnabledInterface $variant
    ) {
        return parent::enableAction(
            $request,
            $variant
        );
    }

    /**
     * Disable entity
     *
     * @param Request          $request Request
     * @param EnabledInterface $entity  Entity to disable
     *
     * @return array Result
     *
     * @Route(
     *      path = "/{variantId}/disable",
     *      name = "admin_product_variant_disable"
     * )
     * @Method({"GET", "POST"})
     *
     * @EntityAnnotation(
     *      class = "elcodi.entity.product_variant.class",
     *      mapping = {
     *          "id" = "~variantId~"
     *      }
     * )
     */
    public function disableAction(
        Request $request,
        EnabledInterface $entity
    ) {
        return parent::disableAction(
            $request,
            $entity
        );
    }

    /**
     * Delete element action
     *
     * @param Request $request      Request
     * @param mixed   $variant      Variant to delete
     * @param string  $redirectPath Redirect path
     *
     * @return RedirectResponse Redirect response
     *
     * @Route(
     *      path = "/{id}/delete",
     *      name = "admin_product_variant_delete"
     * )
     * @Method({"GET", "POST"})
     *
     * @EntityAnnotation(
     *     class = "elcodi.entity.product.class",
     *     name = "product",
     *     mapping = {
     *         "id": "~productId~"
     *     }
     * )
     * @EntityAnnotation(
     *      class = "elcodi.entity.product_variant.class",
     *      name = "variant",
     *      mapping = {
     *          "id" = "~id~"
     *      }
     * )
     */
    public function deleteAction(
        Request $request,
        $variant,
        $redirectPath = null
    ) {
        /**
         * @var ProductInterface $product
         * @var VariantInterface $variant
         */
        $product = $variant->getProduct();

        /*
         * Getting the list of unique Attributes associated with
         * the Variant to be deleted. This is a safety check,
         * since a Variant should *not* have more than one
         * option with the same Attribute
         */
        $variantAttributes = $this->getUniqueAttributesFromVariant($variant);

        $notRemovableAttributes = [];

        /**
         * @var VariantInterface $iteratedVariant
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
         * @var AttributeInterface $variantAttribute
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

        $this->flush($product);

        return parent::deleteAction(
            $request,
            $variant
        );
    }

    /**
     * Given a Variant, return a list of the associated Attributes
     *
     * The Attribute is fetched from the "options" relation. In theory
     * each option in a Variant should belong to a different Attribute.
     *
     * @param VariantInterface $variant
     *
     * @return array
     */
    protected function getUniqueAttributesFromVariant(VariantInterface $variant)
    {
        $variantAttributes = [];

        foreach ($variant->getOptions() as $option) {

            /**
             * @var AttributeInterface $attribute
             */
            $attribute = $option->getAttribute();

            if (!array_key_exists($attribute->getId(), $variantAttributes)) {
                $variantAttributes[$attribute->getId()] = $attribute;
            }
        }

        return $variantAttributes;
    }
}
