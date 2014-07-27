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

namespace Admin\AdminMediaBundle\Controller;

use Admin\AdminCoreBundle\Controller\Abstracts\AbstractAdminController;
use Elcodi\CoreBundle\Entity\Abstracts\AbstractEntity;
use Elcodi\ProductBundle\Entity\Interfaces\ProductInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Mmoreram\ControllerExtraBundle\Annotation\Entity as EntityAnnotation;

/**
 * Class GalleryController
 */
class GalleryController extends AbstractAdminController
{
    /**
     * View gallery action
     *
     * @param Request        $request Request
     * @param AbstractEntity $entity  Entity
     *
     * @return array result
     *
     * @Route(
     *      path = "/{id}/gallery",
     *      name = "admin_product_gallery"
     * )
     * @Template("AdminMediaBundle:Gallery/Component:view.html.twig")
     * @Method({"GET"})
     *
     * @EntityAnnotation(
     *      class = "elcodi.core.product.entity.product.class",
     *      mapping = {
     *          "id" = "~id~"
     *      }
     * )
     */
    public function viewAction(
        Request $request,
        AbstractEntity $entity
    )
    {
        /**
         * @var ProductInterface $entity
         */

        return [
            'entity' => $entity,
            'images' => $entity->getImages(),
        ];
    }

}
