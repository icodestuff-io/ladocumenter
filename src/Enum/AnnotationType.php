<?php


namespace Icodestuff\LaDocumenter\Enum;


use MyCLabs\Enum\Enum;

class AnnotationType
{
    const RESPONSE = 'ResponseExample';
    const BODY_PARAM = 'BodyParam';
    const QUERY_PARAM = 'QueryParam';
    const ENDPOINT = 'Endpoint';
    const GROUP = 'Group';
    const SKIP = 'Skip';
}