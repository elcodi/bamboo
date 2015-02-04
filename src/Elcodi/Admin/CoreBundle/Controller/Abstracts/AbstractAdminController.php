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

namespace Elcodi\Admin\CoreBundle\Controller\Abstracts;

use Closure;
use Doctrine\Common\Persistence\ObjectManager;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Elcodi\Component\Core\Entity\Interfaces\EnabledInterface;

/**
 * Class AbstractAdminController
 */
class AbstractAdminController extends Controller
{
    /**
     * Enable entity
     *
     * @param Request          $request Request
     * @param EnabledInterface $entity  Entity to enable
     *
     * @return array Result
     */
    public function enableAction(
        Request $request,
        EnabledInterface $entity
    ) {
        return $this->getResponse($request, function () use ($entity) {

            /**
             * @var EnabledInterface $entity
             */
            $entity->setEnabled(true);
            $entityManager = $this->getManagerForClass($entity);
            $entityManager->flush($entity);
        });
    }

    /**
     * Disable entity
     *
     * @param Request          $request Request
     * @param EnabledInterface $entity  Entity to disable
     *
     * @return array Result
     */
    public function disableAction(
        Request $request,
        EnabledInterface $entity
    ) {
        return $this->getResponse($request, function () use ($entity) {

            /**
             * @var EnabledInterface $entity
             */
            $entity->setEnabled(false);
            $entityManager = $this->getManagerForClass($entity);
            $entityManager->flush($entity);
        });
    }

    /**
     * Updated edited element action
     *
     * @param Request $request     Request
     * @param Mixed   $entity      Entity to delete
     * @param string  $redirectUrl Redirect url
     *
     * @return RedirectResponse Redirect response
     */
    public function deleteAction(
        Request $request,
        $entity,
        $redirectUrl = null
    ) {
        return $this->getResponse($request, function () use ($entity) {

            /**
             * @var EnabledInterface $entity
             */
            $entityManager = $this->getManagerForClass($entity);
            $entityManager->remove($entity);
            $entityManager->flush($entity);
        }, $redirectUrl);
    }

    /**
     * Controller helpers
     */

    /**
     * Return a RedirectResponse given a route name and an array of parameters
     *
     * @param string $route  Route
     * @param array  $params Params
     *
     * @return RedirectResponse Response
     */
    protected function redirectRoute($route, array $params = array())
    {
        return $this->redirect($this->generateUrl($route, $params));
    }

    /**
     * Output helpers
     */

    /**
     * Return response
     *
     * This method takes into account the type of the request ( GET or POST )
     *
     * @param Request $request     Request
     * @param Closure $closure     Closure
     * @param string  $redirectUrl Redirect url
     *
     * @return mixed Response
     *
     * @throws Exception Something has gone wrong
     */
    protected function getResponse(
        Request $request,
        Closure $closure,
        $redirectUrl = null
    ) {
        try {
            $closure();

            return $this->getOkResponse($request, $redirectUrl);
        } catch (Exception $exception) {
            return $this->getFailResponse($request, $exception);
        }
    }

    /**
     * Return ok response
     *
     * This method takes into account the type of the request ( GET or POST )
     *
     * @param Request $request     Request
     * @param string  $redirectUrl Redirect url
     *
     * @return mixed Response
     */
    protected function getOkResponse(Request $request, $redirectUrl = null)
    {
        if (null === $redirectUrl) {
            $redirectRoute = $request->headers->get('referer');
        } elseif ($redirectUrl instanceof Closure) {
            $redirectRoute = $redirectUrl();
        } else {
            $redirectRoute = $this->generateUrl($redirectUrl);
        }

        return ('GET' === $request->getMethod())
            ? $this->redirect($redirectRoute)
            : new Response(json_encode([
                'result'  => 'ok',
                'code'    => '0',
                'message' => '',
            ]));
    }

    /**
     * Return fail response
     *
     * This method takes into account the type of the request ( GET or POST )
     *
     * @param Request   $request   Request
     * @param Exception $exception Exception
     *
     * @return mixed Response
     *
     * @throws Exception Something has gone wrong
     */
    protected function getFailResponse(Request $request, Exception $exception)
    {
        if ('GET' === $request->getMethod()) {
            throw $exception;
        }

        return new Response(json_encode([
            'result'  => 'ko',
            'code'    => $exception->getCode(),
            'message' => $exception->getMessage(),
        ]));
    }

    /**
     * Save an entity. To ensure the method is simple, the entity will be
     * persisted always
     *
     * @param mixed $entity Entity
     *
     * @return $this self Object
     */
    public function flush($entity)
    {
        /**
         * @var ObjectManager $objectManager
         */
        $objectManager = $this->getManagerForClass($entity);

        $objectManager->persist($entity);
        $objectManager->flush($entity);

        return $this;
    }

    /**
     * Private controller helpers
     *
     * These helpers MUST be private. Should not expose this magic to the whole
     * controller set, but help internal methods
     */

    /**
     * Get entity manager from an entity
     *
     * @param Mixed $entity Entity
     *
     * @return ObjectManager specific manager
     */
    private function getManagerForClass($entity)
    {
        return $this
            ->get('elcodi.manager_provider')
            ->getManagerByEntityNamespace(get_class($entity));
    }

    /**
     * Get entity repository from an entity
     *
     * @param Mixed $entity Entity
     *
     * @return ObjectManager specific manager
     */
    private function getRepositoryForClass($entity)
    {
        return $this
            ->get('elcodi.repository_provider')
            ->getRepositoryByEntityNamespace(get_class($entity));
    }
}
