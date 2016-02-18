<?php

namespace GatherContent\Model;

use \GatherContent\Request;

class Item
{
    use Assignable;

    public $id              = null;
    public $name            = null;
    public $overdue         = null;
    public $parent_id       = null;
    public $position        = null;
    public $project_id      = null;
    public $template_id     = null;
    public $custom_state_id = null;
    public $config          = null;
    public $created_at      = null;
    public $updated_at      = null;
    public $status          = null;
    public $due_dates       = null;

    public $tabs            = [];

    static function retrieveItem($itemId)
    {
        $request = new Request;
        $response = $request->get("items/{$itemId}", []);
        return new Item($response->fetch("data"));
    }

    function files()
    {
        return (new FileCollection)->forItemId($this->id);
    }

    function getTabs()
    {
        if (!$this->tabs) {
            foreach($this->config as $tab) {
                array_push($this->tabs, new Tab($tab));
            }
        }

        return array_values($this->tabs);
    }

}