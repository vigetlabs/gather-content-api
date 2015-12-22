<?php

namespace GatherContent\Model;

class Account
{
    public $id       = null;
    public $name     = null;
    public $slug     = null;
    public $timezone = null;

    public static function all()
    {
        return (new AccountCollection)->all();
    }

    function __construct($attributes = [])
    {
        foreach ($attributes as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }
}