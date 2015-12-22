<?php

class AccountTest extends PHPUnit_Framework_TestCase
{
    function testDefaultAttributeState()
    {
        $subject = new \GatherContent\Model\Account;

        $this->assertNull($subject->id);
        $this->assertNull($subject->name);
        $this->assertNull($subject->slug);
        $this->assertNull($subject->timezone);
    }

    function testSettingAllowedAttributes()
    {
        $attributes = [
            'id'       => '1',
            'name'     => 'Account',
            'slug'     => 'account',
            'timezone' => 'UTC'
        ];

        $subject = new \GatherContent\Model\Account($attributes);

        $this->assertEquals('1',       $subject->id);
        $this->assertEquals('Account', $subject->name);
        $this->assertEquals('account', $subject->slug);
        $this->assertEquals('UTC',     $subject->timezone);
    }

    function testRejectUnknownAttributes()
    {
        $subject = new \GatherContent\Model\Account(['unknown' => 'value']);

        $this->assertObjectNotHasAttribute('unknown', $subject);
    }
}