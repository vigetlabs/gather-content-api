<?php

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

class DummyHTTPClient
{
    public $email   = null;
    public $api_key = null;

    function get($url, $params, $headers) {}
    function post($url, $params, $headers) {}
}

class DummyRequest
{
    function  get($endpoint, $params = []) {}
    function post($endpoint, $params = []) {}
}

class DummyDownloader
{
    function setSourceUrl($url)   {}
    function saveAs($destination) {}
}

trait TestHelpers
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

