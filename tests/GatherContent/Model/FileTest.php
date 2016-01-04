<?php

namespace GatherContent\Model;

class FileTest extends \PHPUnit_Framework_TestCase
{
    use \TestHelpers;

    function setUp()
    {
        $this->removeTempDir();
    }

    function tearDown()
    {
        $this->removeTempDir();
    }

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

    function testSaveToCreatesDirectory()
    {
        $subject = new File;

        $this->assertFileNotExists($this->tempDir());

        $subject->saveTo($this->tempDir());

        $this->assertFileExists($this->tempDir());
    }

    function testSaveToSavesFile()
    {
        $source_url = 'http://example.com/d34db33f';
        $filename   = 'file.jpg';

        $downloader = $this->getMockBuilder('DummyDownloader')->getMock();
        $downloader->method('setSourceUrl')->with($this->equalTo($source_url))->willReturn($downloader);
        $downloader->expects($this->once())->method('saveAs')->with($this->equalTo($this->tempDir() . '/' . $filename))->willReturn(true);

        $subject = new File(['filename' => $filename, 'url' => $source_url], $downloader);

        $subject->saveTo($this->tempDir());
    }

    function testSaveToRequiresUrl()
    {
        $subject = new File(['filename' => 'foo.jpg']);
        $this->assertNull($subject->saveTo($this->tempDir()));
    }

    function testSaveToRequiresFilename()
    {
        $subject = new File(['url' => 'http://example.com/d34db33f']);
        $this->assertNull($subject->saveTo($this->tempDir()));
    }

    function testSaveToReturnsFilename()
    {
        $filename   = 'file.jpg';

        $downloader = $this->getMockBuilder('DummyDownloader')->getMock();
        $downloader->method('setSourceUrl')->willReturn($downloader);
        $downloader->method('saveAs')->willReturn(true);

        $subject = new File(['filename' => $filename, 'url' => 'url'], $downloader);

        $this->assertEquals($this->tempDir() . '/' . $filename, $subject->saveTo($this->tempDir()));
    }

    function testSaveToReturnsNullWhenTargetNotADirectory()
    {
        $target = $this->tempDir() . '/foo.jpg';

        $this->createTempDir();
        touch($target);

        $subject = new File(['filename' => 'foo.jpg', 'url' => 'url']);

        $this->assertNull($subject->saveTo($target));
    }

}
