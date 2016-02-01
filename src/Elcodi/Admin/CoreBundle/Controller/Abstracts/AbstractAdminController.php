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
    protected function enableAction(
        Request $request,
        EnabledInterface $entity
    ) {
        return $this->getResponse($request, function () use ($entity) {

            /**
             * @var EnabledInterface $entity
             */
            $this->enableEntity($entity);
        });
    }

    /**
     * Enables the given entity
     *
     * @param EnabledInterface $entity The entity to disable
     */
    protected function enableEntity(EnabledInterface $entity)
    {
        $entity->setEnabled(true);
        $entityManager = $this->getManagerForClass($entity);
        $entityManager->flush($entity);
    }

    /**
     * Disable entity
     *
     * @param Request          $request Request
     * @param EnabledInterface $entity  Entity to disable
     *
     * @return array Result
     */
    protected function disableAction(
        Request $request,
        EnabledInterface $entity
    ) {
        return $this->getResponse($request, function () use ($entity) {

           $this->disableEntity($entity);
        });
    }

    /**
     * Disables the given entity
     *
     * @param EnabledInterface $entity The entity to disable
     */
    protected function disableEntity(EnabledInterface $entity)
    {
        $entity->setEnabled(false);
        $entityManager = $this->getManagerForClass($entity);
        $entityManager->flush($entity);
    }

    /**
     * Updated edited element action
     *
     * @param Request $request      Request
     * @param Mixed   $entity       Entity to delete
     * @param string  $redirectPath Redirect path
     *
     * @return RedirectResponse Redirect response
     */
    protected function deleteAction(
        Request $request,
        $entity,
        $redirectPath = null
    ) {
        return $this->getResponse($request, function () use ($entity) {
            /**
             * @var EnabledInterface $entity
             */
            $entityManager = $this->getManagerForClass($entity);
            $entityManager->remove($entity);
            $entityManager->flush();

            $this->addFlash(
                'success',
                $this
                    ->get('translator')
                    ->trans('ui.delete.success')
            );

        }, $redirectPath);
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
    protected function redirectRoute($route, array $params = [])
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
     * @param Request $request      Request
     * @param Closure $closure      Closure
     * @param string  $redirectPath Redirect path
     *
     * @return mixed Response
     *
     * @throws Exception Something has gone wrong
     */
    protected function getResponse(
        Request $request,
        Closure $closure,
        $redirectPath = null
    ) {
        try {
            $closure();

            return $this->getOkResponse(
                $request,
                $redirectPath
            );
        } catch (Exception $exception) {
            return $this->getFailResponse($request, $exception);
        }
    }

    /**
     * Return ok response
     *
     * This method takes into account the type of the request ( GET or POST )
     *
     * @param Request $request      Request
     * @param string  $redirectPath Redirect path
     *
     * @return mixed Response
     */
    protected function getOkResponse(
        Request $request,
        $redirectPath = null
    ) {
        if (null === $redirectPath) {
            $redirectUrl = $request->headers->get('referer');
        } else {
            $redirectUrl = $request
                ->getUriForPath($redirectPath);
        }

        return ($request->isMethod(Request::METHOD_GET))
            ? $this->redirect($redirectUrl)
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
        if ($request->isMethod(Request::METHOD_GET)) {
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
    protected function flush($entity)
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
     * Flush cache
     *
     * @return $this self Object
     */
    protected function flushCache()
    {
        $this
            ->get('cache_flusher')
            ->flushCache();

        return $this;
    }

    /**
     * Translate
     *
     * @param string $string String to be translated
     *
     * @return string String translated
     */
    protected function translate($string)
    {
        return $this
            ->get('translator')
            ->trans($string);
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
            ->get('elcodi.provider.manager')
            ->getManagerByEntityNamespace(get_class($entity));
    }
}
