<?php

namespace GatherContent\Model;

trait Collection
{
    private $request_instance = null;

    function __construct($request_instance = null)
    {
        $this->request_instance = $this->createRequest($request_instance);
    }

    private function createRequest($request_instance)
    {
        return (is_null($request_instance)) ? new \GatherContent\Request : $request_instance;
    }

    private function collect($response, $class_name)
    {
        $class_name = "\\GatherContent\\Model\\{$class_name}";

        return array_map(
            function($a) use ($class_name) { return new $class_name($a); },
            $response->fetch('data')
        );
    }

}
