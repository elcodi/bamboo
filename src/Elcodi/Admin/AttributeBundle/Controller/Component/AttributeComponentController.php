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

namespace Elcodi\Admin\AttributeBundle\Controller\Component;

use Doctrine\ORM\Tools\Pagination\Paginator;
use Mmoreram\ControllerExtraBundle\Annotation\Entity as EntityAnnotation;
use Mmoreram\ControllerExtraBundle\Annotation\Form as FormAnnotation;
use Mmoreram\ControllerExtraBundle\Annotation\Paginator as PaginatorAnnotation;
use Mmoreram\ControllerExtraBundle\ValueObject\PaginatorAttributes;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\FormView;

use Elcodi\Admin\CoreBundle\Controller\Abstracts\AbstractAdminController;
use Elcodi\Component\Attribute\Entity\Interfaces\AttributeInterface;

/**
 * Class AttributeComponentController
 *
 * @Route(
 *      path = "attribute"
 * )
 */
class AttributeComponentController extends AbstractAdminController
{
    /**
     * Component for entity list.
     *
     * As a component, this action should not return all the html macro, but
     * only the specific component
     *
     * @param Paginator           $paginator           Paginator instance
     * @param PaginatorAttributes $paginatorAttributes Paginator attributes
     * @param integer             $page                Page
     * @param integer             $limit               Limit of items per page
     *
     * @return array Result
     *
     * @Route(
     *      path = "s/component/{page}/{limit}/{orderByField}/{orderByDirection}",
     *      name = "admin_attribute_list_component",
     *      requirements = {
     *          "page" = "\d*",
     *          "limit" = "\d*",
     *      },
     *      defaults = {
     *          "page" = "1",
     *          "limit" = "50",
     *          "orderByField" = "id",
     *          "orderByDirection" = "DESC",
     *      },
     *      methods = {"GET"}
     * )
     * @Template("AdminAttributeBundle:Attribute:listComponent.html.twig")
     *
     * @PaginatorAnnotation(
     *      attributes = "paginatorAttributes",
     *      class = "elcodi.entity.attribute.class",
     *      page = "~page~",
     *      limit = "~limit~",
     *      orderBy = {
     *          {"x", "~orderByField~", "~orderByDirection~"},
     *      },
     * )
     */
    public function listComponentAction(
        Paginator $paginator,
        PaginatorAttributes $paginatorAttributes,
        $page,
        $limit
    ) {
        return [
            'paginator'        => $paginator,
            'page'             => $page,
            'limit'            => $limit,
            'totalPages'       => $paginatorAttributes->getTotalPages(),
            'totalElements'    => $paginatorAttributes->getTotalElements(),
        ];
    }

    /**
     * New element component action
     *
     * As a component, this action should not return all the html macro, but
     * only the specific component
     *
     * @param FormView           $formView  Form view
     * @param AttributeInterface $attribute Attribute
     *
     * @return array Result
     *
     * @Route(
     *      path = "/{id}/component",
     *      name = "admin_attribute_edit_component",
     *      requirements = {
     *          "id" = "\d+",
     *      },
     *      methods = {"GET", "POST"}
     * )
     * @Route(
     *      path = "/new/component",
     *      name = "admin_attribute_new_component",
     *      methods = {"GET"}
     * )
     * @Template("AdminAttributeBundle:Attribute:editComponent.html.twig")
     *
     * @EntityAnnotation(
     *      class = {
     *          "factory" = "elcodi.factory.attribute",
     *          "method" = "create",
     *          "static" = false
     *      },
     *      name = "attribute",
     *      mapping = {
     *          "id" = "~id~"
     *      },
     *      mappingFallback = true,
     * )
     * @FormAnnotation(
     *      class = "elcodi_admin_attribute_form_type_attribute",
     *      name  = "formView",
     *      entity = "attribute",
     *      handleRequest = true,
     *      validate = "isValid"
     * )
     */
    public function editComponentAction(
        FormView $formView,
        AttributeInterface $attribute
    ) {
        $allAvailableValues = $this
            ->get('elcodi.repository.attribute_value')
            ->findAll();

        $attributeValues = $attribute
            ->getValues()
            ->toArray();

        return [
            'attribute'       => $attribute,
            'form'            => $formView,
            'attributeValues' => $this->getValuesSplittedByComma($attributeValues),
            'allValues'       => $this->getValuesSplittedByComma($allAvailableValues),
        ];
    }

    /**
     * Get values splitted by comma
     *
     * @param array|null $values Values
     *
     * @return string Values splitted by comma
     */
    protected function getValuesSplittedByComma(array $values = null)
    {
        $values = is_array($values)
            ? $values
            : [];

        $values = array_unique($values);

        return implode(',', $values);
    }
}
