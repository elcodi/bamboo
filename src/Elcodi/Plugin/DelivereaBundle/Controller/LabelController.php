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

namespace Elcodi\Plugin\DelivereaBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class LabelController
 */
class LabelController extends Controller
{
    /**
     * Views a label.
     *
     * @param string $delivereaRef The deliverea reference
     *
     * @return array Result
     *
     * @Route(
     *      path = "/label/{delivereaRef}",
     *      name = "deliverea_view_label",
     *      methods = {"GET"}
     * )
     */
    public function viewAction(
        $delivereaRef
    ) {
        $label = $this
            ->get('elcodi_deliverea.manager.label')
            ->getLabel($delivereaRef);

        $filename = printf(
            'attachment;
            filename="label_%s.pdf"',
            $delivereaRef
        );

        $response = new Response(
            $label,
            200,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => $filename,
            ]);

        return $response;
    }
}
