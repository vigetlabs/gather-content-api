<?php

namespace
{
    require_once __DIR__ . "/../vendor/autoload.php";

    \VCR\VCR::configure()
      ->enableLibraryHooks(['curl'])
      ->setMode('once');

    \VCR\VCR::turnOn();

    function dummyObject($properties = [])
    {
        $object = new \StdClass;
        foreach ($properties as $key => $value) {
            $object->$key = $value;
        }
        return $object;
    }
}

namespace Test
{
    class HTTPClient
    {
        public $email   = null;
        public $api_key = null;

        function get($url, $params, $headers) {}
        function post($url, $params, $headers) {}
    }

    class Request
    {
        function  get($endpoint, $params = []) {}
        function post($endpoint, $params = []) {}
    }

    class Downloader
    {
        function setSourceUrl($url)   {}
        function saveAs($destination) {}
    }

    trait Helpers
    {
        function tempDir()
        {
            return __DIR__ . '/../tmp';
        }

        function removeTempDir()
        {
            system("rm -rf " . escapeshellarg($this->tempDir()));
        }

        function createTempDir()
        {
            system("mkdir " . escapeshellarg($this->tempDir()));
        }
    }
}
