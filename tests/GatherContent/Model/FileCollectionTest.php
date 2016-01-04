<?php

namespace GatherContent\Model;

class FileCollectionTest extends \PHPUnit_Framework_TestCase
{

    function testEmptyResponseReturnsNoAccounts()
    {
        $http_response = dummyObject([
            'status' => '200',
            'body'   => '{"data":[]}'
        ]);

        $request = $this->getMockBuilder('DummyRequest')->getMock();

        $request->method('get')
            ->with($this->equalTo('items/1/files'))
            ->willReturn(new \GatherContent\Response($http_response));

        $subject  = new FileCollection($request);
        $this->assertEmpty($subject->forItemId(1));
    }

    function testForItemIdReturnsCollectionOfFiles()
    {

        $http_response = dummyObject([
            'status' => '200',
            'body'   => '{"data":[{"id":2,"item_id":1,"size":121,"field":"el1","filename":"food.jpg","url":"http://example.com/b33f"}]}'
        ]);

        $request = $this->getMockBuilder('DummyRequest')->getMock();

        $request->method('get')
            ->with($this->equalTo('items/1/files'))
            ->willReturn(new \GatherContent\Response($http_response));

        $subject = new FileCollection($request);
        $files   = $subject->forItemId(1);

        $this->assertCount(1, $files);

        $file = $files[0];

        $this->assertInstanceOf('\GatherContent\Model\File', $file);

        $this->assertSame(2,   $file->id);
        $this->assertSame(1,   $file->item_id);
        $this->assertSame(121, $file->size);

        $this->assertEquals('el1',                     $file->field);
        $this->assertEquals('food.jpg',                $file->filename);
        $this->assertEquals('http://example.com/b33f', $file->url);
    }

}
