<?php

namespace GatherContent;

class HTTPClient
{
    public $email   = null;
    public $api_key = null;
    public $totalConcurrentRequests = 10;

    public function __construct($email = null, $api_key = null, $totalConcurrentRequests = 10)
    {
        $this->email   = $email;
        $this->api_key = $api_key;
        $this->totalConcurrentRequests = $totalConcurrentRequests;
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

    public function getMulti($urls, $headers = [])
    {
        return $this->sendMultiRequest($urls, [
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

    private function sendMultiRequest($urls, $additionalCurlOptions)
    {
        // data to be returned
        $results = array();

        // array of curl handles
        $channels = array();

        // initialize the multihandler
        $mh = curl_multi_init();

        $active = 0;
        $urlIndex = 0;

        // Process Loop
        do {
            // Add to the in flight requests
            $numToAdd = $this->totalConcurrentRequests - $active;

            while ($numToAdd-- && $urlIndex < count($urls)) {
                $url = $urls[$urlIndex];
                // initiate individual channel
                $channel = curl_init($url);

                curl_setopt_array($channel, ($this->defaultCurlOptions() + $additionalCurlOptions));

                // add channel to multihandler
                curl_multi_add_handle($mh, $channel);

                $channels[$url] = $channel;
                $urlIndex++;
            }

            do {
                $mrc = curl_multi_exec($mh, $active);
            } while ($mrc === CURLM_CALL_MULTI_PERFORM);

            // This waits for more activity on the multi connection
            curl_multi_select($mh);

            // Check for responses
            while ($multiInfo = curl_multi_info_read($mh)) {
                $channel = $multiInfo['handle'];

                $content = curl_multi_getcontent($channel);
                if ($content) {
                    $response = new \StdClass;
                    $response->status = curl_getinfo($channel, CURLINFO_HTTP_CODE);
                    $response->body   = curl_multi_getcontent($channel);

                    $results[] = $response;
                }
                curl_multi_remove_handle($mh, $channel);
                curl_close($channel);
            }
        } while ($active > 0 || $urlIndex < count($urls));

        // close the multihandler
        curl_multi_close($mh);
        return $results;
    }
}
