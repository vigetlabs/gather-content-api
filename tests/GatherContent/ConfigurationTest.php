<?php

class ConfigurationTest extends PHPUnit_Framework_TestCase
{
    function testDefaultOptions()
    {
        $this->assertNull(\GatherContent\Configuration::$email);
        $this->assertNull(\GatherContent\Configuration::$api_key);
    }

    function testConfigureSetsValues()
    {
        \GatherContent\Configuration::configure('email', 'api-key');

        $this->assertEquals('email',   \GatherContent\Configuration::$email);
        $this->assertEquals('api-key', \GatherContent\Configuration::$api_key);
    }
}