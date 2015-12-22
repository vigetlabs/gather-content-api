<?php

namespace GatherContent\Model;

class ProjectCollectionTest extends \PHPUnit_Framework_TestCase
{
    function testEmptyResponseReturnsNoProjects()
    {
        $http_response = dummyObject([
            'status' => '200',
            'body'   => '{"data":[]}'
        ]);

        $request = $this->getMockBuilder('DummyRequest')->getMock();

        $request->method('get')
            ->with($this->equalTo('projects'), $this->equalTo(['account_id' => '1']))
            ->willReturn(new \GatherContent\Response($http_response));

        $subject  = new ProjectCollection($request);
        $this->assertEmpty($subject->forAccountId('1'));
    }

    function testAllReturnsCollectionOfProjects()
    {
        $http_response = dummyObject([
            'status' => '200',
            'body'   => '{"data":[{"id":"2","account_id":"1","active":true,"name":"Project","overdue":false,"text_direction":"ltr"}]}'
        ]);

        $request = $this->getMockBuilder('DummyRequest')->getMock();

        $request->method('get')
            ->with($this->equalTo('projects'), $this->equalTo(['account_id' => '1']))
            ->willReturn(new \GatherContent\Response($http_response));

        $subject  = new ProjectCollection($request);
        $projects = $subject->forAccountId('1');

        $this->assertCount(1, $projects);

        $project = $projects[0];

        $this->assertInstanceOf('\GatherContent\Model\Project', $project);

        $this->assertEquals('2',       $project->id);
        $this->assertEquals('1',       $project->account_id);
        $this->assertEquals('Project', $project->name);
        $this->assertEquals('ltr',     $project->text_direction);

        $this->assertTrue($project->active);
        $this->assertFalse($project->overdue);
    }
}
