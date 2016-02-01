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

namespace Elcodi\Admin\UserBundle\Controller;

use Mmoreram\ControllerExtraBundle\Annotation\Form as AnnotationForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;

use Elcodi\Component\User\Entity\Abstracts\AbstractUser;

/**
 * Class PasswordController
 *
 * @Route(
 *      path = "/password",
 * )
 */
class PasswordController extends Controller
{
    /**
     * Remember password
     *
     * @param Form    $passwordRememberForm Password remember form
     * @param boolean $isValid              Is valid
     *
     * @return array
     *
     * @Route(
     *      path = "/remember",
     *      name = "admin_password_remember",
     *      methods = {"GET", "POST"}
     * )
     * @Template
     *
     * @AnnotationForm(
     *      class         = "elcodi_admin_user_form_type_password_remember",
     *      handleRequest = true,
     *      name          = "passwordRememberForm",
     *      validate      = "isValid"
     * )
     */
    public function rememberAction(Form $passwordRememberForm, $isValid)
    {
        if ($isValid) {
            $adminUserRepository = $this
                ->get('elcodi.provider.repository')
                ->getRepositoryByEntityParameter('elcodi.entity.admin_user.class');

            $email = $passwordRememberForm
                ->get('email')
                ->getData();

            $this
                ->get('elcodi.manager.password')
                ->rememberPasswordByEmail(
                    $adminUserRepository,
                    $email,
                    'admin_password_recover'
                );

            return $this->redirectToRoute('admin_password_recover_sent');
        }

        return [
            'form' => $passwordRememberForm->createView(),
        ];
    }

    /**
     * Recover password sent action
     *
     * @return array
     *
     * @Route(
     *      path = "/sent",
     *      name = "admin_password_recover_sent",
     *      methods = {"GET"}
     * )
     * @Template
     */
    public function sentAction()
    {
        return [];
    }

    /**
     * Recover password
     *
     * @param Form    $passwordRecoverForm Password recover form
     * @param string  $hash                Hash
     * @param boolean $isValid             Is valid
     *
     * @return array
     *
     * @Route(
     *      path = "/recover/{hash}",
     *      name = "admin_password_recover",
     *      requirements = {
     *          "hash" = "[\dA-Fa-f]+"
     *      },
     *      methods = {"GET", "POST"}
     * )
     * @Template
     *
     * @AnnotationForm(
     *      class         = "elcodi_admin_user_form_type_password_recover",
     *      handleRequest = true,
     *      name          = "passwordRecoverForm",
     *      validate      = "isValid"
     * )
     */
    public function recoverAction(Form $passwordRecoverForm, $isValid, $hash)
    {
        if ($isValid) {
            $customer = $this
                ->get('elcodi.repository.admin_user')
                ->findOneBy([
                    'recoveryHash' => $hash,
                    'email' => $passwordRecoverForm->get('email')->getData(),
                ]);

            if ($customer instanceof AbstractUser) {
                $password = $passwordRecoverForm
                    ->get('password')
                    ->getData();

                $this
                    ->get('elcodi.manager.password')
                    ->recoverPassword($customer, $hash, $password);

                $this->addFlash(
                    'info',
                    $this
                        ->get('translator')
                        ->trans('admin.customer.info.password_changed')
                );
            } else {
                $this->addFlash(
                    'error',
                    $this
                        ->get('translator')
                        ->trans('admin.customer.error.password_change')
                );
            }

            return $this->redirectToRoute('admin_homepage');
        }

        return [
            'form' => $passwordRecoverForm->createView(),
        ];
    }
}
