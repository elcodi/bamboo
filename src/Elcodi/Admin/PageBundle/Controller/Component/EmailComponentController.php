<?php

/*
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
 * @author Elcodi Team <tech@elcodi.com>
 */

namespace Elcodi\Admin\PageBundle\Controller\Component;

use Doctrine\ORM\Tools\Pagination\Paginator;
use Mmoreram\ControllerExtraBundle\Annotation\Entity as EntityAnnotation;
use Mmoreram\ControllerExtraBundle\Annotation\Form as FormAnnotation;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\FormView;

use Elcodi\Admin\CoreBundle\Controller\Abstracts\AbstractAdminController;
use Elcodi\Component\Page\ElcodiPageTypes;
use Elcodi\Component\Page\Entity\Interfaces\PageInterface;

/**
 * Class EmailComponentControllerphp
 *
 * @Route(
 *      path = "/email"
 * )
 */
class EmailComponentController extends AbstractAdminController
{
    /**
     * Component for entity list.
     *
     * As a component, this action should not return all the html macro, but
     * only the specific component
     *
     * @return array Result
     *
     * @Route(
     *      path = "s",
     *      name = "admin_email_list_component",
     * )
     * @Template("AdminPageBundle:Email:listComponent.html.twig")
     * @Method({"GET"})
     */
    public function listComponentAction()
    {
        $emails = $this
            ->get('elcodi.repository.page')
            ->findBy([
                'enabled' => true,
                'type'    => ElcodiPageTypes::TYPE_EMAIL,
            ]);

        return [
            'paginator' => $emails,
        ];
    }

    /**
     * New element component action
     *
     * As a component, this action should not return all the html macro, but
     * only the specific component
     *
     * @param FormView      $formView Form view
     * @param PageInterface $email    Email
     *
     * @return array Result
     *
     * @Route(
     *      path = "/{id}/component",
     *      name = "admin_email_edit_component",
     *      requirements = {
     *          "id" = "\d+",
     *      }
     * )
     * @Template("AdminPageBundle:Email:editComponent.html.twig")
     * @Method({"GET"})
     *
     * @EntityAnnotation(
     *      class = {
     *          "factory" = "elcodi.factory.page",
     *          "method" = "create",
     *          "static" = false
     *      },
     *      name = "email",
     *      mapping = {
     *          "id" = "~id~",
     *          "type" = \Elcodi\Component\Page\ElcodiPageTypes::TYPE_EMAIL,
     *      }
     * )
     * @FormAnnotation(
     *      class = "elcodi_admin_page_form_type_email",
     *      name  = "formView",
     *      entity = "email",
     *      handleRequest = true,
     *      validate = "isValid"
     * )
     */
    public function editComponentAction(
        FormView $formView,
        PageInterface $email
    ) {
        return [
            'email' => $email,
            'form'  => $formView,
        ];
    }
}
