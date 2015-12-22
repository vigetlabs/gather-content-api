<?php

namespace GatherContent\Model;

class Account
{
    use Assignable;

    public $id       = null;
    public $name     = null;
    public $slug     = null;
    public $timezone = null;

    public static function all()
    {
        return (new AccountCollection)->all();
    }

    function projects()
    {
        return (new ProjectCollection)->forAccountId($this->id);
    }

}