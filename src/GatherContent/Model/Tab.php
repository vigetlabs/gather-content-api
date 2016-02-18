<?php

namespace GatherContent\Model;

class Tab
{
    use Assignable;
    
    public $id              = null;
    public $label           = null;
    public $project_id      = null;
    public $parent_id       = null;
    public $template_id     = null;
    public $custom_state_id = null;
    public $name            = null;
    public $elements        = null;

    public $fields          = [];

    function getFields()
    {
        if (!$this->fields) {
            foreach($this->elements as $field) {
                array_push($this->fields, new Field($field));
            }
        }

        return $this->fields;
    }
}