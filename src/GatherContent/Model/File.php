<?php

namespace GatherContent\Model;

class File
{
    use Assignable;

    public $id       = null;
    public $item_id  = null;
    public $size     = null;
    public $field    = null;
    public $filename = null;
    public $url      = null;

    private $downloader_instance = null;

    function __construct($attributes = [], $downloader_instance = null)
    {
        $this->setAttributes($attributes);

        $this->downloader_instance = $this->createDownloader($downloader_instance);
    }

    function saveTo($location)
    {
        if (!file_exists($location)) { mkdir($location, 0777, true); }
        if (!is_dir($location))      { return null; }

        if (!isset($this->url) || !isset($this->filename)) {
            return null;
        }

        $target = $location . '/' . $this->filename;

        $this->downloader_instance
            ->setSourceUrl($this->url)
            ->saveAs($target);

        return $target;
    }

    private function createDownloader($downloader_instance)
    {
        return (is_null($downloader_instance)) ? new \GatherContent\Downloader : $downloader_instance ;
    }

}