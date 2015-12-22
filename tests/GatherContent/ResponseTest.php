<?php

namespace GatherContent;

class ResponseTest extends \PHPUnit_Framework_TestCase
{

    function testWasSuccessfulReturnsTrueOnSuccess()
    {
        $subject = new Response(dummyObject(['status' => 200, 'body' => '{}']));
        $this->assertTrue($subject->wasSuccessful());
    }

    function testWasSuccessfulReturnsTrueWithSuccessClassStatus()
    {
        $subject = new Response(dummyObject(['status' => 201, 'body' => '']));
        $this->assertTrue($subject->wasSuccessful());
    }

    function testWasSuccessfulReturnsFalseOnFailure()
    {
        $subject = new Response(dummyObject(['status' => 401, 'body' => 'Invalid']));
        $this->assertFalse($subject->wasSuccessful());
    }

    function testFetchReturnsExistingKeyWhenSuccessful()
    {
        $http_response = dummyObject(['status' => 200, 'body' => '{"key":"value"}']);

        $subject = new Response($http_response);

        $this->assertEquals('value', $subject->fetch('key'));
    }

    function testFetchReturnsNullKeyWhenUnsuccessful()
    {
        $http_response = dummyObject(['status' => 401, 'body' => '{"key":"value"}']);

        $subject = new Response($http_response);

        $this->assertNull($subject->fetch('key'));
    }

    function testFetchReturnsNullWhenKeyDoesNotExist()
    {
        $http_response = dummyObject(['status' => 200, 'body' => '{"key":"value"}']);

        $subject = new Response($http_response);

        $this->assertNull($subject->fetch('missing'));
    }

}
