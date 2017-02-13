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
 * @author Maksim Karpychev <kodermax@gmail.com>
 */

namespace Elcodi\Plugin\ClearCacheBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Elcodi\Admin\CoreBundle\Controller\Abstracts\AbstractAdminController;
use Elcodi\Plugin\ClearCacheBundle\Services\ClearCache;

/**
 * Class ClearCacheComponentController
 *
 * @Route(
 *      path = "utilities/clearcache"
 * )
 */
class ClearCacheController extends AbstractAdminController
{
    /**
     * View Page Clear Cache
     *
     * @Route(
     *      path = "/",
     *      name = "admin_clear_cache_index"
     * )
     * @Template
     * @Method({"GET"})
     */
    public function indexAction()
    {
        $clearCache = new ClearCache($this->get('kernel')->getCacheDir());
        $arSizes = $clearCache->getSizes();

        return ['sizes' => json_encode($arSizes)];
    }

    /**
     * Clear Cache Action
     * @Route(
     *      path = "/update",
     *      name = "admin_clear_cache_update",
     *      methods = {"POST"}
     * )
     */
    public function editAction()
    {
        $clearCache = new ClearCache($this->get('kernel')->getCacheDir());
        $clearCache->deleteCache();
        $this->addFlash(
            'success',
            $this
                ->get('translator')
                ->trans('elcodi_plugin.clear_cache.cleared')
        );

        return $this->redirectToRoute('admin_clear_cache_index');
    }
}
