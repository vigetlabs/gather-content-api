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
        $subject = new \GatherContent\HTTPClient('user@host.com', 'key');

        $this->assertEquals('user@host.com', $subject->email);
        $this->assertEquals('key',           $subject->api_key);
    }

    function testGetRequestIsSuccessful()
    {
        \VCR\VCR::insertCassette('gathercontent_get_me_success.yml');

        $subject = new \GatherContent\HTTPClient('valid.user@example.com', 'valid-api-key');

        $response = $subject->get('https://api.gathercontent.com/me', [], ['Accept: application/vnd.gathercontent.v0.5+json']);

        $this->assertEquals(200, $response->status);
        $this->assertNotEmpty($response->body);
    }

    function testGetRequestIsUnsuccessful()
    {
        \VCR\VCR::insertCassette('gathercontent_get_me_failure.yml');

        $subject = new \GatherContent\HTTPClient('invalid.user@example.com', 'bogus-api-key');

        $response = $subject->get('https://api.gathercontent.com/me', [], ['Accept: application/vnd.gathercontent.v0.5+json']);

        $this->assertNotEquals(200, $response->status);
        $this->assertEquals('Invalid credentials.', $response->body);
    }

    function testPostRequestIsSuccessful()
    {
        \VCR\VCR::insertCassette('gathercontent_post_projects_success.yml');

        $subject = new \GatherContent\HTTPClient('valid.user@example.com', 'valid-api-key');

        $response = $subject->post(
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

        $subject = new \GatherContent\HTTPClient('invalid.user@example.com', 'bogus-api-key');

        $response = $subject->post(
            'https://api.gathercontent.com/projects',
            ['account_id' => '20225', 'name' => 'Project Name'],
            ['Accept: application/vnd.gathercontent.v0.5+json']
        );

        $this->assertNotEquals(200, $response->status);
        $this->assertEquals('Invalid credentials.', $response->body);
    }

}
