<?php

namespace GatherContent\Model;

class AccountCollection
{
    private $request_instance = null;

    function __construct($request_instance = null)
    {
        $this->request_instance = $this->createRequest($request_instance);
    }

    function all()
    {
        $response = $this->request_instance->get('accounts');
        return array_map(function($a) { return new Account($a); }, $response->fetch('data'));
    }

    private function createRequest($request_instance)
    {
        return (is_null($request_instance)) ? new \GatherContent\Request : $request_instance;
    }
}
