<?php


namespace Icodestuff\LaDocumenter\Contracts;


use Icodestuff\LaDocumenter\Annotation\BodyParam;
use Icodestuff\LaDocumenter\Annotation\Endpoint;
use Icodestuff\LaDocumenter\Annotation\Group;
use Icodestuff\LaDocumenter\Annotation\QueryParam;
use Icodestuff\LaDocumenter\Annotation\ResponseExample;
use Icodestuff\LaDocumenter\Exceptions\AnnotationException;

interface Extractor
{
    /**
     * Strip the response annotation from a controller.
     *
     * @param string $responseAnnotation
     * @return ResponseExample
     * @throws AnnotationException
     */
    public function response(string $responseAnnotation): ResponseExample;

    /**
     * Strip the endpoint annotation from a controller method.
     *
     * @param string $endpointAnnotation
     * @return Endpoint
     * @throws AnnotationException
     */
    public function endpoint(string $endpointAnnotation): Endpoint;

    /**
     * Strip the group annotation from the controller.
     *
     * @param string $groupAnnotation
     * @return Group
     */
    public function group(string $groupAnnotation): Group;

    /**
     * Strip the body param annotation from the controller.
     *
     * @param string $bodyAnnotation
     * @return BodyParam
     * @throws AnnotationException
     */
    public function body(string $bodyAnnotation): BodyParam;

    /**
     * Strip the query param annotation from the controller.
     *
     * @param string $queryAnnotation
     * @return QueryParam
     * @throws AnnotationException
     */
    public function query(string $queryAnnotation): QueryParam;
}