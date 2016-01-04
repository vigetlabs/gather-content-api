<?php

namespace GatherContent\Model;

class FileTest extends \PHPUnit_Framework_TestCase
{
    function testDefaultAttributeState()
    {
        $subject = new File;

        $this->assertNull($subject->id);
        $this->assertNull($subject->item_id);
        $this->assertNull($subject->size);
        $this->assertNull($subject->field);
        $this->assertNull($subject->filename);
        $this->assertNull($subject->url);
    }

    function testSettingAllowedAttributes()
    {
        $attributes = [
            'id'       => 2,
            'item_id'  => 1,
            'size'     => 121,
            'field'    => 'el1',
            'filename' => 'food.jpg',
            'url'      => 'https://gathercontent.s3.amazonaws.com/b33f'
        ];

        $subject = new File($attributes);

        $this->assertSame(2,          $subject->id);
        $this->assertSame(1,          $subject->item_id);
        $this->assertSame(121,        $subject->size);

        $this->assertEquals('el1',      $subject->field);
        $this->assertEquals('food.jpg', $subject->filename);

        $this->assertEquals('https://gathercontent.s3.amazonaws.com/b33f', $subject->url);
    }

}
