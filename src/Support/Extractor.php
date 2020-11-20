<?php


namespace Icodestuff\LaDocumenter\Support;


use Icodestuff\LaDocumenter\Annotation\BodyParam;
use Icodestuff\LaDocumenter\Annotation\Endpoint;
use Icodestuff\LaDocumenter\Annotation\Group;
use Icodestuff\LaDocumenter\Annotation\QueryParam;
use Icodestuff\LaDocumenter\Annotation\ResponseExample;
use Icodestuff\LaDocumenter\Exceptions\AnnotationException;
use Icodestuff\LaDocumenter\Contracts\Extractor as Contract;

class Extractor implements Contract
{
    /**
     * Strip the response annotation from a controller.
     *
     * @param string $responseAnnotation
     * @return ResponseExample
     * @throws AnnotationException
     */
    public function response(string $responseAnnotation): ResponseExample
    {
        $stringedArray = explode(',', str_replace(array( '(', ')' ), '', $responseAnnotation));
        $responses = [];
        $responseExample = new ResponseExample();
        foreach ($stringedArray as $arr) {
            $data = explode('=', $arr);

            $name = preg_replace('/\s+/', '', $data[0]);

            $responses[$name] = $data[1];
        }

        foreach($responses as $item => $value) {
            $responseExample->$item = str_replace('"', '', $value);
        }

        ResponseExample::validate($responses);

        $responseExample->file = file_get_contents($responseExample->file);

        return $responseExample;
    }

    /**
     * Strip the endpoint annotation from a controller method.
     *
     * @param string $endpointAnnotation
     * @return Endpoint
     * @throws AnnotationException
     */
    public function endpoint(string $endpointAnnotation): Endpoint
    {
        $stringedArray = explode(',', str_replace(array( '(', ')'), '', $endpointAnnotation));

        $endpoint = new Endpoint();
        $parameters = [];
        foreach ($stringedArray as $arr) {
            $data = explode('=', $arr);

            $name = preg_replace('/\s+/', '', $data[0]);

            $parameters[$name] = $data[1];
        }

        Endpoint::validate($parameters);

        foreach ($parameters as $item => $value) {
            $endpoint->$item = str_replace('"', '', $value);
        }

        return $endpoint;
    }

    /**
     * Strip the group annotation from the controller.
     *
     * @param string $groupAnnotation
     * @return Group
     */
    public function group(string $groupAnnotation): Group
    {
        $stringedArray = explode(',', str_replace(array( '(', ')'), '', $groupAnnotation));
        $group = new Group();
        $params = [];
        foreach ($stringedArray as $arr) {
            $data = explode('=', $arr);

            $name = preg_replace('/\s+/', '', $data[0]);

            $params[$name] = $data[1];
        }

        foreach ($params as $item => $value) {
            $group->$item = str_replace('"', '', $value);
        }

        return $group;
    }

    /**
     * Strip the body param annotation from the controller.
     *
     * @param string $bodyAnnotation
     * @return BodyParam
     * @throws AnnotationException
     */
    public function body(string $bodyAnnotation): BodyParam
    {
        $stringedArray = explode(',', str_replace(array( '(', ')'), '', $bodyAnnotation));
        $params = [];
        $body = new BodyParam();

        foreach ($stringedArray as $arr) {
            $data = explode('=', $arr);

            $name = preg_replace('/\s+/', '', $data[0]);

            $params[$name] = $data[1];
        }

        BodyParam::validate($params);

        foreach ($params as $item => $value) {
            $body->$item = str_replace('"', '', $value);
        }

        return $body;
    }

    /**
     * Strip the query param annotation from the controller.
     *
     * @param string $queryAnnotation
     * @return QueryParam
     * @throws AnnotationException
     */
    public function query(string $queryAnnotation): QueryParam
    {
        $stringedArray = explode(',', str_replace(array( '(', ')'), '', $queryAnnotation));
        $params = [];
        $query = new QueryParam();
        foreach ($stringedArray as $arr) {
            $data = explode('=', $arr);

            $name = preg_replace('/\s+/', '', $data[0]);

            $params[$name] = $data[1];
        }

        QueryParam::validate($params);

        foreach ($params as $item => $value) {
            $query->$item = str_replace('"', '', $value);
        }

        return $query;
    }
}