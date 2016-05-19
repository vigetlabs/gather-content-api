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

    public $isQA            = null;
    public $bookId          = null;
    public $tabs            = [];
    public $fields          = [];

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

    function getFields() {
        if (!$this->fields) {
            $tabs = $this->getTabs();
            foreach ($tabs as $tab) {
                $this->fields = array_merge($this->fields, $tab->getFields());
            }
        }

        return $this->fields;
    }

    function getBookId() {
        return $this->bookId;
    }

    function setBookId($bookId) {
        $this->bookId = $bookId;
    }

    function isQA () {
        if (is_null($this->isQA)) {
            $this->isQA = strpos($this->name, "Q&A") !== false;
        }
        return $this->isQA;
    }
}