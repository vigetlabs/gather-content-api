<?php

namespace GatherContent\Model;

class Project
{
    use Assignable;

    public $id             = null;
    public $account_id     = null;
    public $active         = null;
    public $name           = null;
    public $overdue        = null;
    public $text_direction = null;

    function items()
    {
        return (new ItemCollection)->forProjectId($this->id);
    }

    function isActive()
    {
        return $this->isFlagEnabled('active');
    }

    function isOverdue()
    {
        return $this->isFlagEnabled('overdue');
    }

    private function isFlagEnabled($flag)
    {
        return ($this->$flag == true) ? true : false ;
    }

}
