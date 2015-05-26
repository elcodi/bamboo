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

use Mmoreram\ControllerExtraBundle\Annotation\Entity as EntityAnnotation;
use Mmoreram\ControllerExtraBundle\Annotation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpKernel\Exception\HttpException;

use Elcodi\Admin\CoreBundle\Controller\Abstracts\AbstractAdminController;
use Elcodi\Component\Language\Entity\Interfaces\LanguageInterface;

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
     * @param LanguageInterface $language The language to enable
     *
     * @return array Result
     *
     * @Route(
     *      path = "/{iso}/enable",
     *      name = "admin_language_enable"
     * )
     * @Method({"POST"})
     *
     * @EntityAnnotation(
     *      class = "elcodi.entity.language.class",
     *      name = "language",
     *      mapping = {
     *          "iso" = "~iso~"
     *      }
     * )
     *
     * @JsonResponse()
     */
    public function enableLanguageAction(
        LanguageInterface $language
    ) {
        $translator = $this->get('translator');

        $this->enableEntity($language);
        $this->flushCache();

        return ['message' => $translator->trans('admin.language.saved.enabled')];
    }

    /**
     * Disable entity
     *
     * @param LanguageInterface $language The language to disable
     *
     * @return array Result
     *
     * @Route(
     *      path = "/{iso}/disable",
     *      name = "admin_language_disable"
     * )
     * @Method({"POST"})
     *
     * @EntityAnnotation(
     *      class = "elcodi.entity.language.class",
     *      name = "language",
     *      mapping = {
     *          "iso" = "~iso~"
     *      }
     * )
     *
     * @JsonResponse()
     */
    public function disableLanguageAction(
        LanguageInterface $language
    ) {
        $translator = $this->get('translator');

        /**
         * We cannot disable the default locale
         */
        $masterLanguage = $configManager = $this
            ->get('elcodi.manager.configuration')
            ->get('store.default_language');

        if ($language->getIso() == $masterLanguage) {
            throw new HttpException(
                '403',
                $translator->trans('admin.language.error.disable_master_language')
            );
        }

        $this->disableEntity($language);
        $this->flushCache();

        return ['message' => $translator->trans('admin.language.saved.disabled')];
    }

    /**
     * Set the master language.
     *
     * @param LanguageInterface $language
     *
     * @return array
     *
     * @Route(
     *      path = "/{iso}/master",
     *      name = "admin_language_master"
     * )
     * @Method({"POST"})
     *
     * @EntityAnnotation(
     *      class = "elcodi.entity.language.class",
     *      name = "language",
     *      mapping = {
     *          "iso" = "~iso~"
     *      }
     * )
     *
     * @JsonResponse()
     */
    public function masterLanguageAction(
        LanguageInterface $language
    ) {
        $translator = $this->get('translator');
        if (!$language->isEnabled()) {
            throw new HttpException(
                '403',
                $translator->trans('admin.language.error.setting_disabled_master_language')
            );
        }

        $configManager = $this->get('elcodi.manager.configuration');
        $configManager->set('store.default_language', $language->getIso());
        $this->flushCache();

        return ['message' => $translator->trans('admin.language.saved.master')];
    }
}
