<?php

namespace Icodestuff\LaDocumenter\Annotation;

use Icodestuff\LaDocumenter\Exceptions\AnnotationException;

/**
 * @Annotation
 */
class ResponseExample
{
    public int $status = 200;
    public string $file;

    /**
     * Validate attributes
     *
     * @param array $responseExample
     * @return array
     * @throws AnnotationException
     */
    public static function validate(array $responseExample)
    {
        if (!is_numeric($responseExample['status'])) {
            throw new AnnotationException('The response status must be a numeric value');
        }

        if (!file_exists(storage_path(str_replace('"', '', $responseExample['file'])))) {
            throw new AnnotationException( sprintf('The file %s does not exist.', $responseExample['file']));
        }

        return $responseExample;
    }
}