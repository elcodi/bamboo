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

namespace ApiRest\Api\Event;

use ApiRest\Api\Configuration\ApiRestConfiguration;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ApiRestEvent
 */
final class ApiRestEvent extends Event
{
    /**
     * @var Request
     *
     * Request
     */
    private $request;

    /**
     * @var ApiRestConfiguration
     *
     * Entity configuration
     */
    private $entityConfiguration;

    /**
     * @var string
     *
     * Verb
     */
    private $verb;

    /**
     * @var integer
     *
     * Entity id
     */
    private $entityId;

    /**
     * @var string
     *
     * Entity relationship
     */
    private $entityRelationship;

    /**
     * @var mixed
     *
     * Response content
     */
    private $responseContent = [
        'jsonapi' => [],
        'data'   => [],
        'links' => [],
        'errors' => [],
        'meta'   => [],
        'included' => [],
    ];

    /**
     * @var integer
     *
     * Response status
     */
    private $responseStatus = 200;

    /**
     * @var array
     *
     * Response headers
     */
    private $responseHeaders = [];

    /**
     * Construct
     *
     * @param Request                   $request             Request
     * @param ApiRestConfiguration|null $entityConfiguration Entity namespace
     * @param string                    $verb                Verb
     * @param integer                   $entityId            Entity Id
     * @param string                    $entityRelationship  Entity Relationship
     */
    function __construct(
        Request $request,
        $entityConfiguration,
        $verb,
        $entityId,
        $entityRelationship
    )
    {
        $this->request = $request;
        $this->entityConfiguration = $entityConfiguration;
        $this->verb = $verb;
        $this->entityId = $entityId;
        $this->entityRelationship = $entityRelationship;
    }

    /**
     * Get Request
     *
     * @return Request Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * Get Entity Configuration
     *
     * @return ApiRestConfiguration Entity configuration
     */
    public function getEntityConfiguration()
    {
        return $this->entityConfiguration;
    }

    /**
     * Get Entity Namespace
     *
     * @return string EntityNamespace
     */
    public function getEntityNamespace()
    {
        return $this
            ->entityConfiguration
            ->getEntityNamespace();
    }

    /**
     * Get Entity Alias
     *
     * @return string EntityAlias
     */
    public function getEntityAlias()
    {
        return $this
            ->entityConfiguration
            ->getEntityAlias();
    }

    /**
     * Get Verb
     *
     * @return string Verb
     */
    public function getVerb()
    {
        return $this->verb;
    }

    /**
     * Get Entity Id
     *
     * @return int Entity Id
     */
    public function getEntityId()
    {
        return $this->entityId;
    }

    /**
     * Get Entity Relationship
     *
     * @return string Entity Relationship
     */
    public function getEntityRelationship()
    {
        return $this->entityRelationship;
    }

    /**
     * Get Response status
     *
     * @return int Response status
     */
    public function getResponseStatus()
    {
        return $this->responseStatus;
    }

    /**
     * Sets Response status
     *
     * @param int $responseStatus Response status
     */
    public function setResponseStatus($responseStatus)
    {
        $this->responseStatus = $responseStatus;
    }

    /**
     * Get Response content
     *
     * @return mixed Response content
     */
    public function getResponseContent()
    {
        return $this->responseContent;
    }

    /**
     * Sets Response content
     *
     * @param mixed $responseContent Response content
     */
    public function setResponseContent($responseContent)
    {
        $this->responseContent = $responseContent;
    }

    /**
     * Set json api
     *
     * @param string $jsonapi Json Api
     */
    public function setResponseJsonapi($jsonapi)
    {
        $this->responseContent['jsonapi'] = $jsonapi;
    }

    /**
     * Get json api
     *
     * @return string Json Api
     */
    public function getResponseJsonapi()
    {
        return $this->responseContent['jsonapi'];
    }

    /**
     * @param $responseData
     */
    public function addResponseData($responseData)
    {
        $this->responseContent['data'] = array_merge(
            $this->responseContent['data'],
            $responseData
        );
    }

    /**$responseLink
     * @param $responseData
     */
    public function setResponseData($responseData)
    {
        $this->responseContent['data'] = $responseData;
    }

    /**
     * @return mixed
     */
    public function getResponseData()
    {
        return $this->responseContent['data'];
    }

    /**
     * @param $responseLinks
     */
    public function addResponseLinks(array $responseLinks)
    {
        $this->responseContent['links'] = array_merge(
            $this->responseContent['links'],
            $responseLinks
        );
    }

    /**
     * @param $responseLink
     */
    public function setResponseLinks($responseLink)
    {
        $this->responseContent['links'] = $responseLink;
    }

    /**
     * @return mixed
     */
    public function getResponseLinks()
    {
        return $this->responseContent['links'];
    }

    /**
     * @param $responseMeta
     */
    public function addResponseMeta($responseMeta)
    {
        $this->responseContent['meta'] = array_merge(
            $this->responseContent['meta'],
            $responseMeta
        );
    }

    /**
     * @param $responseMeta
     */
    public function setResponseMeta($responseMeta)
    {
        $this->responseContent['meta'] = $responseMeta;
    }

    /**
     * @return mixed
     */
    public function getResponseMeta()
    {
        return $this->responseContent['meta'];
    }

    /**
     * Get Response headers
     *
     * @return array Response headers
     */
    public function getResponseHeaders()
    {
        return $this->responseHeaders;
    }

    /**
     * Adds Response header
     *
     * @param array $responseHeader Response header
     */
    public function addResponseHeader($responseHeader)
    {
        $this->responseHeaders[] = $responseHeader;
    }

    /**
     * Resolve response
     *
     * @param mixed $responseErrors  Response errors
     * @param int   $responseStatus  Response status
     * @param array $responseHeaders Response headers
     */
    public function resolveWithError(
        array $responseErrors,
        $responseStatus,
        array $responseHeaders = []

    )
    {
        $this->responseContent['errors'] = array_merge(
            $this->responseContent['errors'],
            $responseErrors
        );
        $this->responseStatus = $responseStatus;
        $this->responseHeaders = $responseHeaders;

        $this->stopPropagation();
    }

    /**
     * Resolve with 404 Resource not found
     */
    public function resolveWithResourceNotFound()
    {
        $this->resolveWithError(['Resource not found'], 404);
    }
}
