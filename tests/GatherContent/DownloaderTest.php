<?php

namespace GatherContent;

class DownloaderTest extends \PHPUnit_Framework_TestCase
{
    use \TestHelpers;

    function setUp()
    {
        $this->removeTempDir();
        $this->createTempDir();
    }

    function tearDown()
    {
        $this->removeTempDir();
    }

    function testConstructorSetsSourceUrl()
    {
        $subject = new Downloader('source_url');
        $this->assertEquals('source_url', $subject->source_url);
    }

    function testSetSourceUrlSetsSourceUrl()
    {
        $subject = new Downloader;
        $this->assertNull($subject->source_url);

        $subject->setSourceUrl('source_url');
        $this->assertEquals('source_url', $subject->source_url);
    }

    function testSetSourceUrlReturnsSelf()
    {
        $subject = new Downloader;
        $this->assertEquals($subject, $subject->setSourceUrl('url'));
    }

    function testSaveAsDownloadsFileToTarget()
    {
        \VCR\VCR::turnOn();
        \VCR\VCR::insertCassette('gathercontent_save_file.yml');

        $file_url        = 'https://gathercontent.s3.amazonaws.com/filename_hash';
        $target_filename = $this->tempDir() . '/file.jpg';

        $this->assertFileNotExists($target_filename);

        $subject = new Downloader($file_url);

        $subject->saveAs($target_filename);

        $this->assertFileExists($target_filename);
        $this->assertEquals('file-contents', file_get_contents($target_filename));

        \VCR\VCR::eject();
        \VCR\VCR::turnOff();
    }

}