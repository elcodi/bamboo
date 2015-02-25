<?php

namespace Elcodi\Admin\GeoBundle\Controller;

use Elcodi\Admin\CoreBundle\Controller\Abstracts\AbstractAdminController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\Form;
use Mmoreram\ControllerExtraBundle\Annotation\Entity as EntityAnnotation;
use Mmoreram\ControllerExtraBundle\Annotation\Form as FormAnnotation;

/**
 * Class Controller for Address
 *
 * @Route(
 *      path = "/address",
 * )
 */
class AddressController extends AbstractAdminController
{
    /**
     * List configuration values
     *
     * @return array Result
     *
     * @Route(
     *      path = "",
     *      name = "admin_address_edit"
     * )
     * @Template
     * @Method({"GET","POST"})
     *
     * @EntityAnnotation(
     *      class = {
     *          "factory" = "elcodi.factory.address",
     *          "method" = "create",
     *          "static" = false
     *      },
     *      mapping = {
     *          "id" = "~id~"
     *      },
     *      mappingFallback = true,
     *      name = "address",
     *      persist = true
     * )
     * @FormAnnotation(
     *      class = "admin_geo_form_type_address",
     *      name  = "form",
     *      entity = "address",
     *      handleRequest = true,
     *      validate = "isValid"
     * )
     */
    public function editAction(Form $form, $isValid)
    {
        return [
            'form' => $form->createView()
        ];
    }

    public function newAction()
    {

    }
}
