<?php

namespace GatherContent;

class ConfigurationTest extends \PHPUnit_Framework_TestCase
{
    function testDefaultOptions()
    {
        $this->assertNull(Configuration::$email);
        $this->assertNull(Configuration::$api_key);
    }

    function testConfigureSetsValues()
    {
        \GatherContent\Configuration::configure('email', 'api-key');

        $this->assertEquals('email',   Configuration::$email);
        $this->assertEquals('api-key', Configuration::$api_key);
    }
}