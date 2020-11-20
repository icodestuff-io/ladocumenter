<?php

namespace Icodestuff\LaDocumenter;

use Icodestuff\LaDocumenter\Annotation\Endpoint;
use Icodestuff\LaDocumenter\Annotation\Group;
use Icodestuff\LaDocumenter\Annotation\LaDocumenterRoute;
use Icodestuff\LaDocumenter\Enum\AnnotationType;
use Icodestuff\LaDocumenter\Support\Extractor;
use Illuminate\Routing\Route;
use Illuminate\Routing\Router;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Minime\Annotations\Interfaces\ReaderInterface;
use Icodestuff\LaDocumenter\Contracts\LaDocumenter as Contract;

class LaDocumenter implements Contract
{
    protected ReaderInterface $reader;
    protected Router $router;
    protected Extractor $extractor;

    /**
     * LaDocumenter constructor.
     * @param ReaderInterface $reader
     * @param Router $router
     * @param Extractor $extractor
     */
    public function __construct(ReaderInterface $reader, Router $router, Extractor $extractor)
    {
        $this->reader = $reader;
        $this->router = $router;
        $this->extractor = $extractor;
    }

    /**
     * Get routes that can be documented
     *
     * @return Collection
     */
    public function getFilteredRoutes()
    {
        $routes = collect($this->router->getRoutes()->getRoutes());

        return $routes->map(function (Route $route){
            // Remove if the middleware isn't an array.
            if (!is_array($route->action['middleware'])) {
                return false;
            }

            // Remove if the route is not using the api middleware.
            if (!in_array(config('documentation.routes'), $route->action['middleware'])) {
                return false;
            }

            // Remove if the callable is missing
            if (!is_string($route->action['uses'])) {
                return false;
            }

            $uses = explode("@", (string)$route->action['uses']);

            // check if uri already has forward slash. If missing, this will add it.
            $uri = (substr($route->uri, 0, 1) === '/') ? $route->uri : DIRECTORY_SEPARATOR . $route->uri;

            $laDocumenterRoute = new LaDocumenterRoute();
            $laDocumenterRoute->uri = $uri;
            $laDocumenterRoute->httpMethod = $route->methods[0];
            $laDocumenterRoute->requiresAuth = count(array_intersect(config('documentation.auth_middleware'), (array)$route->middleware())) > 0;
            $laDocumenterRoute->class = $uses[0];
            $laDocumenterRoute->classMethod = $uses[1];

            return $laDocumenterRoute;
        })->reject(function ($val){
            return $val === false;
        });
    }

    /**
     * Get docs for an endpoint.
     *
     * @param LaDocumenterRoute $documenterRoute
     * @return LaDocumenterRoute
     * @throws \ReflectionException
     */
    public function getMethodDocBlock(LaDocumenterRoute $documenterRoute): LaDocumenterRoute
    {
        $annotations = $this->reader->getMethodAnnotations($documenterRoute->class, $documenterRoute->classMethod);
        $endpointAnnotations = collect($annotations->get(AnnotationType::ENDPOINT()));
        $responseAnnotations = collect($annotations->get(AnnotationType::RESPONSE()));
        $bodyAnnotations = collect($annotations->get(AnnotationType::BODY_PARAM()));
        $queryAnnotations = collect($annotations->get(AnnotationType::QUERY_PARAM()));

        if ($endpointAnnotations->isNotEmpty()) {
            $endpointAnnotation = $endpointAnnotations->first();
            $documenterRoute->endpoint = $this->extractor->endpoint($endpointAnnotation);
        } else {
            $endpoint = new Endpoint();
            $endpoint->name = Str::ucfirst($documenterRoute->classMethod);
            $documenterRoute->endpoint = $endpoint;
        }



        if ($responseAnnotations->isNotEmpty()) {
            $documenterRoute->responses = $responseAnnotations->map(function ($responseAnnotation) {
                return $this->extractor->response($responseAnnotation);
            })->toArray();
        }


        if ($bodyAnnotations->isNotEmpty()) {
            $documenterRoute->bodyParams = $bodyAnnotations->map(function ($bodyAnnotation){
                return $this->extractor->body($bodyAnnotation);
            });
        }

        if ($queryAnnotations->isNotEmpty()) {
            $documenterRoute->queryParams = $queryAnnotations->map(function ($queryAnnotation){
                return $this->extractor->query($queryAnnotation);
            });
        }


        return $documenterRoute;
    }

    /**
     * Get the group from a controller class
     *
     * @param $class
     * @return Group
     * @throws \ReflectionException
     */
    public function getClassDocBlocks($class): Group
    {
        $groupAnnotation = collect($this->reader->getClassAnnotations($class)->get(AnnotationType::GROUP()));

        if ($groupAnnotation->isEmpty()) {
            $group = new Group();
            $group->name = $class;
            return $group;
        }

        return $this->extractor->group($groupAnnotation->first());
    }

    /**
     * Group endpoints by class and namespace.
     *
     * @param Collection|LaDocumenterRoute[] $documenterRoutes
     * @return Collection
     */
    public function groupEndpoints(Collection $documenterRoutes): Collection
    {
        $documenterRoutes = $documenterRoutes->groupBy(function (LaDocumenterRoute $documenterRoute){
            return $documenterRoute->class;
        });

        return $documenterRoutes->groupBy(function ($item, $key) {
            $reflectionClass = new \ReflectionClass($key);

            $item->group = $this->getClassDocBlocks($key);
            $namespace = str_replace(config('documentation.controller_path'), '', $reflectionClass->getNamespaceName());

            if (empty($namespace)) {
                // Set namespace to Root if is default controller namespace.
                $namespace = 'Root';
            }

            return $namespace;
        });
    }
}