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

namespace Elcodi\Store\GeoBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use Elcodi\Store\CoreBundle\Controller\Traits\TemplateRenderTrait;

/**
 * Address controllers
 *
 * @Route(
 *      path = "/location",
 * )
 */
class LocationController extends Controller
{
    use TemplateRenderTrait;

    /**
     * This is the max location type that we allow to select.
     *
     * @var string
     */
    protected $maxLocationType = 'city';

    /**
     * Show the city selectors
     *
     * @param string $locationId The location id
     *
     * @return Response
     *
     * @Route(
     *      path = "/selectors/{locationId}",
     *      name = "location_selectors",
     *      methods = {"GET"},
     *      defaults={
     *          "locationId"   = null
     *      }
     * )
     */
    public function showCitySelectorAction($locationId)
    {
        $selects = $this
            ->get('elcodi_store.form.location_selector_builder')
            ->getSelects(
                $locationId,
                $this->maxLocationType
            );

        return $this->renderTemplate(
            'Subpages:location-selector.html.twig',
            [
                'selects'         => $selects,
                'maxLocationType' => $this->maxLocationType,
            ]
        );
    }
}
