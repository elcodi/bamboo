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

namespace Elcodi\Admin\StoreBundle\Controller;

use Mmoreram\ControllerExtraBundle\Annotation\Entity as EntityAnnotation;
use Mmoreram\ControllerExtraBundle\Annotation\Form as FormAnnotation;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\Form;

use Elcodi\Admin\CoreBundle\Controller\Abstracts\AbstractAdminController;
use Elcodi\Component\Store\Entity\Interfaces\StoreInterface;

/**
 * Class Controller for Store
 *
 * @Route(
 *      path = "/store/",
 * )
 */
class StoreController extends AbstractAdminController
{
    /**
     * Store settings
     *
     * @param Form $storeSettingsType Store settings type
     *
     * @return array Result
     *
     * @Route(
     *      path = "settings",
     *      name = "admin_store_settings",
     *      methods = {"GET", "POST"}
     * )
     * @Template
     *
     * @EntityAnnotation(
     *      class = {
     *          "factory" = "elcodi.wrapper.store",
     *          "method" = "get",
     *          "static" = false
     *      },
     *      name = "store",
     *      persist = false
     * )
     * @FormAnnotation(
     *      class         = "elcodi_admin_store_form_type_store_settings",
     *      name          = "storeSettingsType",
     *      entity        = "store",
     *      handleRequest = true
     * )
     */
    public function settingsAction(Form $storeSettingsType)
    {
        if ($storeSettingsType->isValid()) {
            $this
                ->saveStoreAndAddFlash(
                    $storeSettingsType->getData()
                );

            return $this->redirectRoute("admin_store_settings");
        }

        return [
            'form' => $storeSettingsType->createView(),
        ];
    }

    /**
     * Store address
     *
     * @param Form $storeAddressType Store address type
     *
     * @return array Result
     *
     * @Route(
     *      path = "address",
     *      name = "admin_store_address",
     *      methods = {"GET", "POST"}
     * )
     * @Template
     *
     * @EntityAnnotation(
     *      class = {
     *          "factory" = "elcodi.wrapper.store",
     *          "method" = "get",
     *          "static" = false
     *      },
     *      name = "store",
     *      persist = false
     * )
     * @FormAnnotation(
     *      class         = "elcodi_admin_store_form_type_store_address",
     *      name          = "storeAddressType",
     *      entity        = "store",
     *      handleRequest = true
     * )
     */
    public function addressAction(Form $storeAddressType)
    {
        if ($storeAddressType->isValid()) {
            $this
                ->saveStoreAndAddFlash(
                    $storeAddressType->getData()
                );

            return $this->redirectRoute("admin_store_address");
        }

        return [
            'form' => $storeAddressType->createView(),
        ];
    }

    /**
     * Store corporate
     *
     * @param Form $storeCorporateType Store corporate type
     *
     * @return array Result
     *
     * @Route(
     *      path = "profile",
     *      name = "admin_store_corporate",
     *      methods = {"GET", "POST"}
     * )
     * @Template
     *
     * @EntityAnnotation(
     *      class = {
     *          "factory" = "elcodi.wrapper.store",
     *          "method" = "get",
     *          "static" = false
     *      },
     *      name = "store",
     *      persist = false
     * )
     * @FormAnnotation(
     *      class         = "elcodi_admin_store_form_type_store_corporate",
     *      name          = "storeCorporateType",
     *      entity        = "store",
     *      handleRequest = true
     * )
     */
    public function corporateAction(Form $storeCorporateType)
    {
        if ($storeCorporateType->isValid()) {
            $this
                ->saveStoreAndAddFlash(
                    $storeCorporateType->getData()
                );

            return $this->redirectRoute("admin_store_corporate");
        }

        return [
            'form' => $storeCorporateType->createView(),
        ];
    }

    /**
     * Save store and add success flash
     *
     * @param StoreInterface $store Store
     *
     * @return $this Self object
     */
    private function saveStoreAndAddFlash(StoreInterface $store)
    {
        $this
            ->get('elcodi.object_manager.store')
            ->flush($store);

        $this->addFlash(
            'success',
            'admin.store.saved'
        );

        return $this;
    }
}
