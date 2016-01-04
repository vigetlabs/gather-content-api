<?php

namespace GatherContent;

class Downloader
{

    public $source_url = null;

    function __construct($source_url = null)
    {
        $this->source_url = $source_url;
    }

    function setSourceUrl($url)
    {
        $this->source_url = $url;
        return $this;
    }

    function saveAs($destination)
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => false,
            CURLOPT_FILE           => fopen($destination, 'w+'),
            CURLOPT_TIMEOUT        => 60,
            CURLOPT_URL            => $this->source_url
        ]);

        curl_exec($curl);
        curl_close($curl);

        return true;
    }

}
