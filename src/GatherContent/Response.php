<?php

namespace GatherContent;

class Response
{
    private $status_code = null;
    private $body        = null;

    function __construct($http_response)
    {
        $this->status_code = (string)$http_response->status;
        $this->body        = $http_response->body;
    }

    function wasSuccessful()
    {
        return preg_match("/^2/", $this->status_code) ? true : false;
    }

    function fetch($key)
    {
        return $this->decoded()[$key];
    }

    private function decoded()
    {
        return $this->wasSuccessful() ? json_decode($this->body, true) : [];
    }
}
