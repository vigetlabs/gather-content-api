<?php

namespace GatherContent\Model;

class ProjectTest extends \PHPUnit_Framework_TestCase
{
    function testDefaultAttributeState()
    {
        $subject = new Project;

        $this->assertNull($subject->id);
        $this->assertNull($subject->account_id);
        $this->assertNull($subject->active);
        $this->assertNull($subject->name);
        $this->assertNull($subject->overdue);
        $this->assertNull($subject->text_direction);
    }

    function testSettingAllowedAttributes()
    {
        $attributes = [
            'id'             => '2',
            'account_id'     => '1',
            'active'         => true,
            'name'           => 'Project',
            'overdue'        => false,
            'text_direction' => 'ltr'
        ];

        $subject = new Project($attributes);

        $this->assertEquals('2',       $subject->id);
        $this->assertEquals('1',       $subject->account_id);
        $this->assertEquals('Project', $subject->name);
        $this->assertEquals('ltr',     $subject->text_direction);

        $this->assertTrue($subject->active);
        $this->assertFalse($subject->overdue);
    }

    function testRejectUnknownAttributes()
    {
        $subject = new Project(['unknown' => 'value']);

        $this->assertObjectNotHasAttribute('unknown', $subject);
    }

    function testIsActiveWhenNull()
    {
        $subject = new Project;
        $this->assertFalse($subject->isActive());
    }

    function testIsActiveWhenFalse()
    {
        $subject = new Project(['active' => false]);
        $this->assertFalse($subject->isActive());
    }

    function testIsActiveWhenTrue()
    {
        $subject = new Project(['active' => true]);
        $this->assertTrue($subject->isActive());
    }

    function testIsOverdueWhenNull()
    {
        $subject = new Project;
        $this->assertFalse($subject->isOverdue());
    }

    function testIsOverdueWhenFalse()
    {
        $subject = new Project(['overdue' => false]);
        $this->assertFalse($subject->isOverdue());
    }

    function testIsOverdueWhenTrue()
    {
        $subject = new Project(['overdue' => true]);
        $this->assertTrue($subject->isOverdue());
    }

}
