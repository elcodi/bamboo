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
 */

namespace Elcodi\Admin\AttributeBundle\Controller;

use Mmoreram\ControllerExtraBundle\Annotation\Entity as EntityAnnotation;
use Mmoreram\ControllerExtraBundle\Annotation\Form as FormAnnotation;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

use Elcodi\Admin\CoreBundle\Controller\Abstracts\AbstractAdminController;
use Elcodi\Component\Attribute\Entity\Interfaces\AttributeInterface;
use Elcodi\Component\Attribute\Entity\Interfaces\ValueInterface;
use Elcodi\Component\Core\Entity\Interfaces\EnabledInterface;

/**
 * Class Controller for Attribute
 *
 * @Route(
 *      path = "/attribute",
 * )
 */
class AttributeController extends AbstractAdminController
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
     *      path = "s",
     *      name = "admin_attribute_list",
     *      methods = {"GET"}
     * )
     * @Template
     */
    public function listAction()
    {
        return [];
    }

    /**
     * Edit and Saves attribute
     *
     * @param Request            $request   Request
     * @param FormInterface      $form      Form
     * @param AttributeInterface $attribute Attribute
     * @param boolean            $isValid   Is valid
     *
     * @return RedirectResponse Redirect response
     *
     * @Route(
     *      path = "/{id}",
     *      name = "admin_attribute_edit",
     *      requirements = {
     *          "id" = "\d+",
     *      },
     *      methods = {"GET"}
     * )
     * @Route(
     *      path = "/{id}/update",
     *      name = "admin_attribute_update",
     *      requirements = {
     *          "id" = "\d+",
     *      },
     *      methods = {"POST"}
     * )
     *
     * @Route(
     *      path = "/new",
     *      name = "admin_attribute_new",
     *      methods = {"GET"}
     * )
     * @Route(
     *      path = "/new/update",
     *      name = "admin_attribute_save",
     *      methods = {"POST"}
     * )
     *
     * @EntityAnnotation(
     *      class = {
     *          "factory" = "elcodi.factory.attribute",
     *          "method" = "create",
     *          "static" = false
     *      },
     *      mapping = {
     *          "id" = "~id~"
     *      },
     *      mappingFallback = true,
     *      name = "attribute",
     *      persist = true
     * )
     * @FormAnnotation(
     *      class = "elcodi_admin_attribute_form_type_attribute",
     *      name  = "form",
     *      entity = "attribute",
     *      handleRequest = true,
     *      validate = "isValid"
     * )
     *
     * @Template
     */
    public function editAction(
        Request $request,
        FormInterface $form,
        AttributeInterface $attribute,
        $isValid
    ) {
        if ($isValid) {
            $values = explode(',', $request
                ->request
                ->get('values'));

            $this->evaluateAttributeValues($attribute, $values);

            $this->flush($attribute);

            $this->addFlash('success', 'Changes saved');

            return $this->redirectToRoute('admin_attribute_edit', [
                'id' => $attribute->getId(),
            ]);
        }

        return [
            'attribute' => $attribute,
            'form'      => $form->createView(),
        ];
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
     *      path = "/{id}/enable",
     *      name = "admin_attribute_enable"
     * )
     * @Method({"GET", "POST"})
     *
     * @EntityAnnotation(
     *      class = "elcodi.core.attribute.entity.attribute.class",
     *      mapping = {
     *          "id" = "~id~"
     *      }
     * )
     */
    public function enableAction(
        Request $request,
        EnabledInterface $entity
    ) {
        return parent::enableAction(
            $request,
            $entity
        );
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
     *      path = "/{id}/disable",
     *      name = "admin_attribute_disable"
     * )
     * @Method({"GET", "POST"})
     *
     * @EntityAnnotation(
     *      class = "elcodi.core.attribute.entity.attribute.class",
     *      mapping = {
     *          "id" = "~id~"
     *      }
     * )
     */
    public function disableAction(
        Request $request,
        EnabledInterface $entity
    ) {
        return parent::disableAction(
            $request,
            $entity
        );
    }

    /**
     * Delete entity
     *
     * @param Request $request     Request
     * @param mixed   $entity      Entity to delete
     * @param string  $redirectUrl Redirect url
     *
     * @return RedirectResponse Redirect response
     *
     * @Route(
     *      path = "/{id}/delete",
     *      name = "admin_attribute_delete"
     * )
     * @Method({"GET", "POST"})
     *
     * @EntityAnnotation(
     *      class = "elcodi.core.attribute.entity.attribute.class",
     *      mapping = {
     *          "id" = "~id~"
     *      }
     * )
     */
    public function deleteAction(
        Request $request,
        $entity,
        $redirectUrl = null
    ) {
        return parent::deleteAction(
            $request,
            $entity,
            'admin_attribute_list'
        );
    }

    /**
     * Given an attribute and an array of Values, perform database and relation
     * stuff
     *
     * @param AttributeInterface $attribute Attribute
     * @param array              $values    Values
     *
     * @return $this Self object
     */
    public function evaluateAttributeValues(AttributeInterface $attribute, array $values = [])
    {
        $actualValues = [];
        $values = array_filter($values, function ($value) {
            return !empty($value);
        });

        /**
         * We remove all deleted values
         */
        $attribute->setValues(
            $attribute
                ->getValues()
                ->filter(function (ValueInterface $value) use ($attribute, $values, &$actualValues) {

                    $found = false;
                    if (in_array($value->getValue(), $values)) {
                        $actualValues[] = $value->getValue();
                        $found = true;
                    } else {
                        $attribute->removeValue($value);
                    }

                    return $found;
                })
        );

        $newValues = array_diff($values, $actualValues);

        foreach ($newValues as $newValue) {
            $value = $this
                ->get('elcodi.factory.attribute_value')
                ->create()
                ->setValue($newValue)
                ->setAttribute($attribute);
            $attribute->addValue($value);
        }

        return $this;
    }
}
