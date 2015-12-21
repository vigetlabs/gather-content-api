<?php

namespace GatherContent;

class Request
{
    static $email   = null;
    static $api_key = null;

    private $headers = [
        'Accept: application/vnd.gathercontent.v0.5+json'
    ];

    public static function configure($email, $api_key)
    {
        self::$email   = $email;
        self::$api_key = $api_key;
    }

    function __construct($client = null)
    {
        $this->client = $this->createClient($client);

        $this->client->email   = self::$email;
        $this->client->api_key = self::$api_key;
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
