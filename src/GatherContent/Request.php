<?php

namespace GatherContent;

class Request
{
    private $headers = [
        'Accept: application/vnd.gathercontent.v0.5+json'
    ];

    function __construct($client = null)
    {
        $this->client = $this->createClient($client);

        $this->client->email   = Configuration::$email;
        $this->client->api_key = Configuration::$api_key;
    }

    function get($endpoint, $params = [])
    {
        $http_response = $this->client->get($this->getUrl($endpoint), $params, $this->headers);
        return new Response($http_response);
    }

    function post($endpoint, $params = [])
    {
        $http_response = $this->client->post($this->getUrl($endpoint), $params, $this->headers);
        return new Response($http_response);
    }

    private function getUrl($endpoint)
    {
        return "https://api.gathercontent.com/{$endpoint}";
    }

    private function createClient($client)
    {
        return (is_null($client)) ? new HTTPClient : $client;
    }

}
