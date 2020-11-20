<?php


namespace Icodestuff\LaDocumenter\Annotation;

/**
 * @Annotation
 */
class LaDocumenterRoute
{
    public string $uri;
    public string $httpMethod;
    public bool $requiresAuth;
    public string $namespace;
    public string $class;
    public string $classMethod;
    public Endpoint $endpoint;
    /**
     * @var ResponseExample[]
     */
    public array $responses = [];

    /**
     * @var BodyParam[]
     */
    public array $bodyParams = [];

    /**
     * @var QueryParam[]
     */
    public array $queryParams = [];
}