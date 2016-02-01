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

namespace Elcodi\Admin\PageBundle\Controller;

use Mmoreram\ControllerExtraBundle\Annotation\Entity as EntityAnnotation;
use Mmoreram\ControllerExtraBundle\Annotation\Form as FormAnnotation;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

use Elcodi\Admin\CoreBundle\Controller\Abstracts\AbstractAdminController;
use Elcodi\Component\Page\Entity\Interfaces\PageInterface;

/**
 * Class Controller for Email
 *
 * @Route(
 *      path = "/email",
 * )
 */
class EmailController extends AbstractAdminController
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
     *      path = "s/",
     *      name = "admin_email_list",
     *      methods = {"GET"},
     * )
     * @Template
     */
    public function listAction()
    {
        return [];
    }

    /**
     * Edit and Saves page
     *
     * @param FormInterface $form    Form
     * @param PageInterface $email   Email
     * @param boolean       $isValid Is valid
     *
     * @return RedirectResponse Redirect response
     *
     * @Route(
     *      path = "/{id}",
     *      name = "admin_email_edit",
     *      requirements = {
     *          "id" = "\d+",
     *      },
     *      methods = {"GET"}
     * )
     * @Route(
     *      path = "/{id}/update",
     *      name = "admin_email_update",
     *      requirements = {
     *          "id" = "\d+",
     *      },
     *      methods = {"POST"}
     * )
     *
     * @EntityAnnotation(
     *      class = {
     *          "factory" = "elcodi.factory.page",
     *          "method" = "create",
     *          "static" = false
     *      },
     *      mapping = {
     *          "id" = "~id~",
     *          "type" = \Elcodi\Component\Page\ElcodiPageTypes::TYPE_EMAIL,
     *      },
     *      name = "email",
     *      persist = true
     * )
     * @FormAnnotation(
     *      class = "elcodi_admin_page_form_type_email",
     *      name  = "form",
     *      entity = "email",
     *      handleRequest = true,
     *      validate = "isValid"
     * )
     *
     * @Template
     */
    public function editAction(
        FormInterface $form,
        PageInterface $email,
        $isValid
    ) {
        if ($isValid) {
            $this->flush($email);

            $this->addFlash('success', 'admin.mailing.saved');

            return $this->redirectToRoute('admin_email_list');
        }

        return [
            'email' => $email,
            'form'  => $form->createView(),
        ];
    }
}
