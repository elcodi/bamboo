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

namespace Elcodi\Store\ProductBundle\Controller;

use Doctrine\ORM\EntityNotFoundException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Elcodi\Component\Product\Entity\Interfaces\PackInterface;
use Elcodi\Component\Product\Entity\Interfaces\ProductInterface;
use Elcodi\Component\Product\Entity\Interfaces\PurchasableInterface;
use Elcodi\Store\CoreBundle\Controller\Traits\TemplateRenderTrait;

/**
 * Product related actions
 */
class PurchasableController extends Controller
{
    use TemplateRenderTrait;

    /**
     * Purchasable related view
     *
     * @param PurchasableInterface $purchasable Purchasable
     *
     * @return array
     *
     * @throws EntityNotFoundException Purchasable not found
     *
     * @Route(
     *      path = "/purchasable/{id}/related",
     *      name = "store_purchasable_related",
     *      requirements = {
     *          "id": "\d+",
     *      },
     *      methods = {"GET"}
     * )
     */
    public function relatedAction($id)
    {
        $purchasable = $this
            ->get('elcodi.repository.purchasable')
            ->find($id);

        if (!$purchasable instanceof PurchasableInterface) {
            throw new EntityNotFoundException('Purchasable not found');
        }

        $relatedProducts = $this
            ->get('elcodi.related_purchasables_provider')
            ->getRelatedPurchasables($purchasable, 3);

        return $this->renderTemplate('Modules:_purchasable-related.html.twig', [
            'purchasables' => $relatedProducts,
        ]);
    }

    /**
     * Purchasable view
     *
     * @param integer $id   Purchasable id
     * @param string  $slug Product slug
     *
     * @return array
     *
     * @throws EntityNotFoundException Purchasable not found
     *
     * @Route(
     *      path = "/product/{slug}/{id}",
     *      name = "store_product_view",
     *      requirements = {
     *          "slug": "[\w-]+",
     *          "id": "\d+",
     *      },
     *      methods = {"GET"}
     * )
     * @Route(
     *      path = "/pack/{slug}/{id}",
     *      name = "store_purchasable_pack_view",
     *      requirements = {
     *          "slug": "[\w-]+",
     *          "id": "\d+",
     *      },
     *      methods = {"GET"}
     * )
     */
    public function viewAction($id, $slug)
    {
        $purchasable = $this
            ->get('elcodi.repository.purchasable')
            ->find($id);

        if (!$purchasable instanceof PurchasableInterface) {
            throw new EntityNotFoundException('Purchasable not found');
        }

        /**
         * We must check that the purchasable slug is right. Otherwise we must
         * return a Redirection 301 to the right url
         */
        if ($slug !== $purchasable->getSlug()) {
            $route = $this
                ->get('request_stack')
                ->getCurrentRequest()
                ->get('_route');

            return $this->redirectToRoute($route, [
                'id'   => $purchasable->getId(),
                'slug' => $purchasable->getSlug(),
            ], 301);
        }

        $useStock = $this
            ->get('elcodi.store')
            ->getUseStock();

        $template = $this->resolveTemplateName($purchasable);
        $variableName = $this->resolveVariableName($purchasable);

        return $this->renderTemplate($template, [
            $variableName => $purchasable,
            'useStock'    => $useStock,
        ]);
    }

    /**
     * Resolve view given the purchasable instance
     *
     * @param PurchasableInterface $purchasable Purchasable
     *
     * @return string template name
     */
    private function resolveTemplateName(PurchasableInterface $purchasable)
    {
        if ($purchasable instanceof ProductInterface) {
            return $purchasable->hasVariants()
                ? 'Pages:product-view-variant.html.twig'
                : 'Pages:product-view-item.html.twig';
        }

        if ($purchasable instanceof PackInterface) {
            return 'Pages:purchasable-pack-view.html.twig';
        }

        return '';
    }

    /**
     * Resolve the variable name given the purchasable instance
     *
     * @param PurchasableInterface $purchasable Purchasable
     *
     * @return string variable name
     */
    private function resolveVariableName(PurchasableInterface $purchasable)
    {
        if ($purchasable instanceof ProductInterface) {
            return 'product';
        }

        if ($purchasable instanceof PackInterface) {
            return 'pack';
        }

        return '';
    }
}
