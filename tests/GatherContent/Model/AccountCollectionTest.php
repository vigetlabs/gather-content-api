<?php

class DummyRequest
{
    function  get($endpoint, $params = []) {}
    function post($endpoint, $params = []) {}
}

class AccountCollectionTest extends PHPUnit_Framework_TestCase
{
    function testEmptyResponseReturnsNoAccounts()
    {
        $http_response = dummyObject([
            'status' => '200',
            'body'   => '{"data":[]}'
        ]);

        $request = $this->getMockBuilder('DummyRequest')->getMock();

        $request->method('get')
            ->with($this->equalTo('accounts'))
            ->willReturn(new \GatherContent\Response($http_response));

        $subject  = new \GatherContent\Model\AccountCollection($request);
        $this->assertEmpty($subject->all());
    }

    function testAllReturnsCollectionOfAccounts()
    {
        $http_response = dummyObject([
            'status' => '200',
            'body'   => '{"data":[{"id":"1","name":"Name","slug":"slug","timezone":"UTC"}]}'
        ]);

        $request = $this->getMockBuilder('DummyRequest')->getMock();

        $request->method('get')
            ->with($this->equalTo('accounts'))
            ->willReturn(new \GatherContent\Response($http_response));

        $subject  = new \GatherContent\Model\AccountCollection($request);
        $accounts = $subject->all();

        $this->assertCount(1, $accounts);

        $account = $accounts[0];

        $this->assertEquals('1',    $account->id);
        $this->assertEquals('Name', $account->name);
        $this->assertEquals('slug', $account->slug);
        $this->assertEquals('UTC',  $account->timezone);
    }
}