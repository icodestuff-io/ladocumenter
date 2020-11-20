<?php

namespace Icodestuff\LaDocumenter\Annotation;

use Icodestuff\LaDocumenter\Exceptions\AnnotationException;

/**
 * @Annotation
 */
class QueryParam
{
    public string $name;
    public string $type = 'string';
    public string $status = 'required';
    public string $description = '';

    /**
     * Validate Query Param
     *
     * @param array $queryParam
     * @return array
     * @throws AnnotationException
     */
    public static function validate(array $queryParam)
    {
        if (!isset($queryParam['name'])) {
            if (!is_string($queryParam['name'])) {
                throw new AnnotationException('The name in @Body must be a string.');
            }
            throw new AnnotationException('The name of the @Body is undefined.');
        }

        return $queryParam;
    }
}