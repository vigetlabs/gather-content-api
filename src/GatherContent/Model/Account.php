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

    public static function findById($id)
    {
        return (new AccountCollection)->findById($id);
    }

    public static function findByName($name)
    {
        return (new AccountCollection)->findByName($name);
    }

    public static function findBySlug($slug)
    {
        return (new AccountCollection)->findBySlug($slug);
    }

    function projects()
    {
        return (new ProjectCollection)->forAccountId($this->id);
    }

}