<?php

class HTTPClientTest extends PHPUnit_Framework_TestCase
{
    function setUp()
    {
        \VCR\VCR::turnOn();
    }

    function tearDown()
    {
        \VCR\VCR::eject();
        \VCR\VCR::turnOff();
    }

    function testConstructorSetsValues()
    {
        $client = new \GatherContent\HTTPClient('user@host.com', 'key');

        $this->assertEquals('user@host.com', $client->email);
        $this->assertEquals('key',           $client->api_key);
    }

    function testGetRequestIsSuccessful()
    {
        \VCR\VCR::insertCassette('gathercontent_get_me_success.yml');

        $client = new \GatherContent\HTTPClient('valid.user@example.com', 'valid-api-key');

        $response = $client->get('https://api.gathercontent.com/me', [], ['Accept: application/vnd.gathercontent.v0.5+json']);

        $this->assertEquals(200, $response->status);
        $this->assertNotEmpty($response->body);
    }

    function testGetRequestIsUnsuccessful()
    {
        \VCR\VCR::insertCassette('gathercontent_get_me_failure.yml');

        $client = new \GatherContent\HTTPClient('invalid.user@example.com', 'bogus-api-key');

        $response = $client->get('https://api.gathercontent.com/me', [], ['Accept: application/vnd.gathercontent.v0.5+json']);

        $this->assertNotEquals(200, $response->status);
        $this->assertEquals('Invalid credentials.', $response->body);
    }

    function testPostRequestIsSuccessful()
    {
        \VCR\VCR::insertCassette('gathercontent_post_projects_success.yml');

        $client = new \GatherContent\HTTPClient('valid.user@example.com', 'valid-api-key');

        $response = $client->post(
            'https://api.gathercontent.com/projects',
            ['account_id' => '20225', 'name' => 'Project Name'],
            ['Accept: application/vnd.gathercontent.v0.5+json']
        );

        $this->assertEquals(202, $response->status);
        $this->assertEmpty($response->body);
    }

    function testPostRequestIsUnsuccessful()
    {
        \VCR\VCR::insertCassette('gathercontent_post_projects_failure.yml');

        $client = new \GatherContent\HTTPClient('invalid.user@example.com', 'bogus-api-key');

        $response = $client->post(
            'https://api.gathercontent.com/projects',
            ['account_id' => '20225', 'name' => 'Project Name'],
            ['Accept: application/vnd.gathercontent.v0.5+json']
        );

        $this->assertNotEquals(200, $response->status);
        $this->assertEquals('Invalid credentials.', $response->body);
    }

}
