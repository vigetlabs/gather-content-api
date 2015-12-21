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
