<?php

namespace GatherContent\Model;

class AccountCollectionTest extends \PHPUnit_Framework_TestCase
{
    function buildCollection($accounts)
    {
        $stub = $this->getMockBuilder('\GatherContent\Model\AccountCollection')
                     ->setMethods(['all'])
                     ->getMock();

        $stub->method('all')->willReturn($accounts);

        return $stub;
    }

    function testEmptyResponseReturnsNoAccounts()
    {
        $http_response = dummyObject([
            'status' => '200',
            'body'   => '{"data":[]}'
        ]);

        $request = $this->getMockBuilder('\Test\Request')->getMock();

        $request->method('get')
            ->with($this->equalTo('accounts'))
            ->willReturn(new \GatherContent\Response($http_response));

        $subject  = new AccountCollection($request);
        $this->assertEmpty($subject->all());
    }

    function testAllReturnsCollectionOfAccounts()
    {
        $http_response = dummyObject([
            'status' => '200',
            'body'   => '{"data":[{"id":1,"name":"Name","slug":"slug","timezone":"UTC"}]}'
        ]);

        $request = $this->getMockBuilder('\Test\Request')->getMock();

        $request->method('get')
            ->with($this->equalTo('accounts'))
            ->willReturn(new \GatherContent\Response($http_response));

        $subject  = new AccountCollection($request);
        $accounts = $subject->all();

        $this->assertCount(1, $accounts);

        $account = $accounts[0];

        $this->assertInstanceOf('\GatherContent\Model\Account', $account);

        $this->assertSame(1, $account->id);

        $this->assertEquals('Name', $account->name);
        $this->assertEquals('slug', $account->slug);
        $this->assertEquals('UTC',  $account->timezone);
    }

    function testFindByIdReturnsNullWhenNoAccounts()
    {
        $subject = $this->buildCollection([]);
        $this->assertNull($subject->findById('2'));
    }

    function testFindByIdReturnsNullWhenNoneFound()
    {
        $account = new Account(['id' => 1]);
        $subject = $this->buildCollection([$account]);

        $this->assertNull($subject->findById(2));
    }

    function testFindByIdReturnsAccountForId()
    {
        $account_1 = new Account(['id' => 1]);
        $account_2 = new Account(['id' => 2]);

        $subject = $this->buildCollection([$account_1, $account_2]);

        $this->assertEquals($account_1, $subject->findById(1));
    }

    function testFindByNameReturnsNullWhenNoAccounts()
    {
        $subject = $this->buildCollection([]);
        $this->assertNull($subject->findByName('Viget'));
    }

    function testFindByNameReturnsNullWhenNoneFound()
    {
        $account = new Account(['name' => 'Viget']);
        $subject = $this->buildCollection([$account]);

        $this->assertNull($subject->findByName('Missing'));
    }

    function testFindByNameReturnsAccountForName()
    {
        $account_1 = new Account(['name' => 'Viget']);
        $account_2 = new Account(['name' => 'Other']);

        $subject = $this->buildCollection([$account_1, $account_2]);

        $this->assertEquals($account_1, $subject->findByName('Viget'));
    }

    function testFindBySlugReturnsNullWhenNoAccounts()
    {
        $subject = $this->buildCollection([]);
        $this->assertNull($subject->findBySlug('viget'));
    }

    function testFindBySlugReturnsNullWhenNoneFound()
    {
        $account = new Account(['slug' => 'viget']);
        $subject = $this->buildCollection([$account]);

        $this->assertNull($subject->findBySlug('missing'));
    }

    function testFindBySlugReturnsAccountForSlug()
    {
        $account_1 = new Account(['slug' => 'viget']);
        $account_2 = new Account(['slug' => 'other']);

        $subject = $this->buildCollection([$account_1, $account_2]);

        $this->assertEquals($account_1, $subject->findBySlug('viget'));
    }

}