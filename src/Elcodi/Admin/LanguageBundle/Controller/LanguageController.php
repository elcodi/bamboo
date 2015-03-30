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

namespace Elcodi\Admin\LanguageBundle\Controller;

use Exception;
use Mmoreram\ControllerExtraBundle\Annotation\Entity as EntityAnnotation;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

use Elcodi\Admin\CoreBundle\Controller\Abstracts\AbstractAdminController;
use Elcodi\Component\Core\Entity\Interfaces\EnabledInterface;

/**
 * Class Controller for Language
 *
 * @Route(
 *      path = "/language",
 * )
 */
class LanguageController extends AbstractAdminController
{

    /**
     * List elements of certain entity type.
     *
     * This action is just a wrapper, so should never get any data,
     * as this is component responsibility
     *
     * @return array Result
     *
     * @Route(
     *      path = "s/list",
     *      name = "admin_language_list"
     * )
     * @Template
     * @Method({"GET"})
     */
    public function listAction()
    {
        return [];
    }

    /**
     * Enable entity
     *
     * @param Request          $request Request
     * @param EnabledInterface $entity  Entity to enable
     *
     * @return array Result
     *
     * @Route(
     *      path = "/{iso}/enable",
     *      name = "admin_language_enable"
     * )
     * @Method({"GET", "POST"})
     *
     * @EntityAnnotation(
     *      class = "elcodi.core.language.entity.language.class",
     *      mapping = {
     *          "iso" = "~iso~"
     *      }
     * )
     */
    public function enableAction(
        Request $request,
        EnabledInterface $entity
    ) {
        $result = parent::enableAction(
            $request,
            $entity
        );

        $this->flushCache();

        return $result;
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
     *      path = "/{iso}/disable",
     *      name = "admin_language_disable"
     * )
     * @Method({"GET", "POST"})
     *
     * @EntityAnnotation(
     *      class = "elcodi.core.language.entity.language.class",
     *      mapping = {
     *          "iso" = "~iso~"
     *      }
     * )
     */
    public function disableAction(
        Request $request,
        EnabledInterface $entity
    ) {

        /**
         * We cannot disable the default locale
         */
        $masterLanguage = $this
            ->container
            ->getParameter('locale');

        if ($entity->getIso() == $masterLanguage) {
            return $this->getFailResponse(
                $request,
                new Exception('You cannot disable your master language')
            );
        }

        $result = parent::disableAction(
            $request,
            $entity
        );

        $this->flushCache();

        return $result;
    }
}
