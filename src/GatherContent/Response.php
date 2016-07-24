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
        $decoded = $this->decoded();
        return (array_key_exists($key, $decoded)) ? $decoded[$key] : null;
    }

    private function decoded()
    {
        if ($this->wasSuccessful() && is_array(json_decode($this->body, true))) {
            return json_decode($this->body, true);
        }

        throw new \Exception("Response not successful");
    }

    public function getStatus() {
        return $this->status_code;
    }

    public function getBody() {
        return $this->body;
    }
}
