<?php


namespace Icodestuff\LaDocumenter\Contracts;


use Doctrine\Common\Annotations\AnnotationException;
use Icodestuff\LaDocumenter\Annotation\Group;
use Icodestuff\LaDocumenter\Annotation\LaDocumenterRoute;
use Illuminate\Support\Collection;

interface LaDocumenter
{
    /**
     * Get routes that can be documented
     *
     * @return Collection
     */
    public function getFilteredRoutes();

    /**
     * Get docs for an endpoint.
     *
     * @param LaDocumenterRoute $documenterRoute
     * @return LaDocumenterRoute
     * @throws AnnotationException
     * @throws \ReflectionException
     */
    public function getMethodDocBlock(LaDocumenterRoute $documenterRoute): LaDocumenterRoute;

    /**
     * Get the group from a controller class
     *
     * @param $class
     * @return Group
     * @throws \ReflectionException
     */
    public function getClassDocBlocks($class): Group;

    /**
     * Group endpoints by class and namespace.
     *
     * @param Collection|LaDocumenterRoute[] $documenterRoutes
     * @return Collection
     */
    public function groupEndpoints(Collection $documenterRoutes): Collection;
}