<?php

namespace GatherContent\Model;

class ItemCollectionTest extends \PHPUnit_Framework_TestCase
{
    function testEmptyResponseReturnsNoProjects()
    {
        $http_response = dummyObject([
            'status' => '200',
            'body'   => '{"data":[]}'
        ]);

        $request = $this->getMockBuilder('DummyRequest')->getMock();

        $request->method('get')
            ->with($this->equalTo('items'), $this->equalTo(['project_id' => '1']))
            ->willReturn(new \GatherContent\Response($http_response));

        $subject  = new ItemCollection($request);
        $this->assertEmpty($subject->forProjectId('1'));
    }

    function testForProjectIdReturnsCollectionOfItems()
    {
        $http_response = dummyObject([
            'status' => '200',
            'body'   => '{"data":[{"id":2,"name":"Item","overdue":false,"parent_id":1,"position":0,"project_id":2,"template_id":3}]}'
        ]);

        $request = $this->getMockBuilder('DummyRequest')->getMock();

        $request->method('get')
            ->with($this->equalTo('items'), $this->equalTo(['project_id' => '2']))
            ->willReturn(new \GatherContent\Response($http_response));

        $subject = new ItemCollection($request);
        $items   = $subject->forProjectId('2');

        $this->assertCount(1, $items);

        $item = $items[0];

        $this->assertInstanceOf('\GatherContent\Model\Item', $item);

        $this->assertEquals(2,      $item->id);
        $this->assertEquals('Item', $item->name);
        $this->assertEquals(1,      $item->parent_id);
        $this->assertEquals(0,      $item->position);
        $this->assertEquals(2,      $item->project_id);
        $this->assertEquals(3,      $item->template_id);

        $this->assertFalse($item->overdue);
    }

}