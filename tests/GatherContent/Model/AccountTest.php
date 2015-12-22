<?php

namespace GatherContent\Model;

class AccountTest extends \PHPUnit_Framework_TestCase
{
    function testDefaultAttributeState()
    {
        $subject = new Account;

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

        $subject = new Account($attributes);

        $this->assertEquals('1',       $subject->id);
        $this->assertEquals('Account', $subject->name);
        $this->assertEquals('account', $subject->slug);
        $this->assertEquals('UTC',     $subject->timezone);
    }

    function testRejectUnknownAttributes()
    {
        $subject = new Account(['unknown' => 'value']);

        $this->assertObjectNotHasAttribute('unknown', $subject);
    }
}