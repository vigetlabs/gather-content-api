<?php

namespace GatherContent;

class RequestTest extends \PHPUnit_Framework_TestCase
{

    private $default_headers = [
        'Accept: application/vnd.gathercontent.v0.5+json'
    ];

    function testConstructorPassesValuesToHttpClient()
    {
        $client = new \Test\HTTPClient;

        Configuration::configure('user@host.com', 'api-key');

        $subject = new Request($client);

        $this->assertEquals('user@host.com', $client->email);
        $this->assertEquals('api-key',       $client->api_key);
    }

    function testGetMakesSuccessfulRequestWithClient()
    {
        $client = $this->getMockBuilder('\Test\HTTPClient')->getMock();
        $client->method('get')
            ->with($this->equalTo('https://api.gathercontent.com/me'), $this->equalTo([]), $this->equalTo($this->default_headers))
            ->willReturn(dummyObject(['status' => '200', 'body' => '{"key":"value"}']));

        $subject = new Request($client);

        $response = $subject->get('me');

        $this->assertTrue($response->wasSuccessful());
        $this->assertEquals('value', $response->fetch('key'));
    }

    function testGetMakesUnsuccessfulRequestWithClient()
    {
        $client = $this->getMockBuilder('\Test\HTTPClient')->getMock();
        $client->method('get')
            ->with($this->equalTo('https://api.gathercontent.com/me'), $this->equalTo([]), $this->equalTo($this->default_headers))
            ->willReturn(dummyObject(['status' => '401', 'body' => 'Invalid credentials.']));

        $subject = new Request($client);

        $response = $subject->get('me');

        $this->assertFalse($response->wasSuccessful());
        $this->assertNull($response->fetch('key'));
    }

    function testPostMakesSuccessfulRequestWithClient()
    {
        $client = $this->getMockBuilder('\Test\HTTPClient')->getMock();
        $client->method('post')
            ->with($this->equalTo('https://api.gathercontent.com/accounts'), $this->equalTo(['account_id' => '100']), $this->equalTo($this->default_headers))
            ->willReturn(dummyObject(['status' => '202', 'body' => '']));

        $subject = new Request($client);

        $response = $subject->post('accounts', ['account_id' => '100']);

        $this->assertTrue($response->wasSuccessful());
        $this->assertNull($response->fetch('key'));
    }

}