<?php

namespace Icodestuff\LaDocumenter\Annotation;

use Icodestuff\LaDocumenter\Exceptions\AnnotationException;

/**
 * @Annotation
 */
class Endpoint
{
    public string $name;
    public string $description = '';

    /**
     * Validate Endpoint
     *
     * @param array $endpoint
     * @return array
     * @throws AnnotationException
     */
    public static function validate(array $endpoint)
    {
        if (!isset($endpoint['name'])) {
            if (!is_string($endpoint['name'])) {
                throw new AnnotationException('The name in @Endpoint must be a string.');
            }
            throw new AnnotationException('The name of the @Endpoint is undefined.');
        }

        return $endpoint;
    }
}