<?php

/**
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

namespace Elcodi\StoreUserBundle\Controller;

use Mmoreram\ControllerExtraBundle\Annotation\Form as AnnotationForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

use Elcodi\Component\User\Entity\Abstracts\AbstractUser;
use Elcodi\StoreCoreBundle\Controller\Traits\TemplateRenderTrait;

/**
 * Class PasswordController
 *
 * @Route(
 *      path = "/password",
 * )
 */
class PasswordController extends Controller
{
    use TemplateRenderTrait;

    /**
     * Remember password
     *
     * @param Form    $passwordRememberForm Password remember form
     * @param boolean $isValid              Is valid
     *
     * @return Response Response
     *
     * @Route(
     *      path = "/remember",
     *      name = "store_password_remember",
     *      methods = {"GET"}
     * )
     *
     * @AnnotationForm(
     *      class         = "store_user_form_type_password_remember",
     *      handleRequest = true,
     *      name          = "passwordRememberForm",
     *      validate      = "isValid"
     * )
     */
    public function rememberAction(Form $passwordRememberForm, $isValid)
    {
        if ($isValid) {

            $customerRepository = $this
                ->get('elcodi.repository_provider')
                ->getRepositoryByEntityParameter('elcodi.core.user.entity.customer.class');

            $email = $passwordRememberForm->getData()['email'];
            $emailFound = $this
                ->get('elcodi.core.user.service.password_manager')
                ->rememberPasswordByEmail(
                    $customerRepository,
                    $email,
                    'store_password_recover'
                );

            if ($emailFound) {
                return new RedirectResponse(
                    $this->generateUrl('store_password_recover_sent')
                );
            }
        }

        return $this->renderTemplate(
            'User/password-remember.html.twig',
            [
                'form' => $passwordRememberForm->createView()
            ]
        );
    }

    /**
     * Recover password sent action
     *
     * @return Response Response
     *
     * @Route(
     *      path = "/sent",
     *      name = "store_password_recover_sent",
     *      methods = {"GET"}
     * )
     */
    public function sentAction()
    {
        /**
         * If user is already logged, go to redirect url
         */
        if ($this->get('security.context')->isGranted('ROLE_CUSTOMER')) {
            return new RedirectResponse($this->generateUrl('store_homepage'));
        }

        return $this->renderTemplate('Pages/user-password-sent.html.twig');
    }

    /**
     * Recover password
     *
     * @param Form    $passwordRecoverForm Password recover form
     * @param string  $hash                Hash
     * @param boolean $isValid             Is valid
     *
     * @return Response Response
     *
     * @Route(
     *      path = "/recover/{hash}",
     *      name = "store_password_recover",
     *      requirements = {
     *          "hash" = "[\dA-Fa-f]+"
     *      },
     *      methods = {"GET"}
     * )
     *
     * @AnnotationForm(
     *      class         = "store_user_form_type_password_recover",
     *      handleRequest = true,
     *      name          = "passwordRecoverForm",
     *      validate      = "isValid"
     * )
     */
    public function recoverAction(Form $passwordRecoverForm, $isValid, $hash)
    {
        if ($isValid) {

            $customer = $this
                ->get('elcodi.repository_provider')
                ->getRepositoryByEntityParameter('elcodi.core.user.entity.customer.class')
                ->findOneBy([
                    'recoveryHash' => $hash,
                ]);

            if ($customer instanceof AbstractUser) {

                $password = $passwordRecoverForm->getData()['password'];

                $this
                    ->get('elcodi.core.user.service.password_manager')
                    ->recoverPassword($customer, $hash, $password);

                return new RedirectResponse($this->generateUrl('store_homepage'));
            }
        }

        return $this->renderTemplate(
            'Pages/user-password-recover.html.twig',
            [
                'form' => $passwordRecoverForm->createView()
            ]
        );
    }
}
