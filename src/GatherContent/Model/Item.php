<?php

namespace GatherContent\Model;

class Item
{
    use Assignable;

    public $id          = null;
    public $name        = null;
    public $overdue     = null;
    public $parent_id   = null;
    public $position    = null;
    public $project_id  = null;
    public $template_id = null;

}