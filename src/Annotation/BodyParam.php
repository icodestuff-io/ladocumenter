<?php

namespace Icodestuff\LaDocumenter\Annotation;

use Icodestuff\LaDocumenter\Exceptions\AnnotationException;

/**
 * @Annotation
 */
class BodyParam
{
    public string $name;
    public string $type = 'string';
    public string $status = 'required';
    public string $description = '';

    /**
     * Validate Body Param
     *
     * @param array $bodyParam
     * @return array
     * @throws AnnotationException
     */
    public static function validate(array $bodyParam)
    {
        if (!isset($bodyParam['name'])) {
            if (!is_string($bodyParam['name'])) {
                throw new AnnotationException('The name in @Body must be a string.');
            }
            throw new AnnotationException('The name of the @Body is undefined.');
        }

        return $bodyParam;
    }
}