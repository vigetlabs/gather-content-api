<?php

namespace GatherContent;

class HTTPClient
{
    public $email   = null;
    public $api_key = null;

    public function __construct($email = null, $api_key = null)
    {
        $this->email   = $email;
        $this->api_key = $api_key;
    }

    public function get($base_url, $params = [], $headers = [])
    {
        $request_url = $base_url;

        if (!empty($params)) {
            $request_url.= '?' . http_build_query($params);
        }

        return $this->sendRequest($request_url, [
            CURLOPT_POST       => false,
            CURLOPT_HTTPHEADER => $headers
        ]);
    }

    public function post($url, $params = [], $headers = [])
    {
        return $this->sendRequest($url, [
            CURLOPT_POST       => true,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_POSTFIELDS => http_build_query($params)
        ]);
    }

    private function defaultCurlOptions()
    {
        return [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_USERPWD        => "{$this->email}:{$this->api_key}",
            CURLOPT_SSL_VERIFYPEER => true
        ];
    }

    private function sendRequest($url, $additionalCurlOptions)
    {
        $curl = curl_init($url);

        curl_setopt_array($curl, ($this->defaultCurlOptions() + $additionalCurlOptions));

        $body   = curl_exec($curl);
        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);

        $response = new \StdClass;
        $response->status = $status;
        $response->body   = $body;

        return $response;
    }

}
