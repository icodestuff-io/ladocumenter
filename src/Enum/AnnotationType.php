<?php


namespace Icodestuff\LaDocumenter\Enum;


use MyCLabs\Enum\Enum;

/**
 * @method static AnnotationType RESPONSE()
 * @method static AnnotationType BODY_PARAM()
 * @method static AnnotationType QUERY_PARAM()
 * @method static AnnotationType ENDPOINT()
 * @method static AnnotationType GROUP()
 * @method static AnnotationType SKIP()
 */
class AnnotationType extends Enum
{
    private const RESPONSE = 'ResponseExample';
    private const BODY_PARAM = 'BodyParam';
    private const QUERY_PARAM = 'QueryParam';
    private const ENDPOINT = 'Endpoint';
    private const GROUP = 'Group';
    private const SKIP = 'Skip';
}