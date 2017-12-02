<?php

namespace GatherContent\Model;

use \GatherContent\Request;

class Item
{
    use Assignable;
    use TabsContainer;

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
    public $type            = null;

    /** @var  File[] */
    private $files = null;

    static function retrieveItem($itemId)
    {
        $request = new Request;
        $response = $request->get("items/{$itemId}", []);
        return new Item($response->fetch("data"));
    }

    function getFiles()
    {
        // This triggers a Request to GatherContent. Only do this if we don't already have data
        if ($this->files === null) {
            $this->files = (new FileCollection)->forItemId($this->id);
        }

        return $this->files;
    }

    function setFiles($files) {
        $this->files = $files;
    }

    function getBookId() {
        if (is_null($this->bookId) && !is_null($this->parent_id)) {
            $parent = Item::retrieveItem($this->parent_id);
            $bookId = $parent->getTabs()[0]->getFields()[0]->value;
            $this->setBookId($bookId);
        }

        return $this->bookId;
    }

    function setBookId($bookId) {
        $this->bookId = $bookId;
        return $this;
    }

    function isQA () {
        if (is_null($this->isQA)) {
            $this->isQA = strpos($this->name, "Q&A") !== false;
        }
        return $this->isQA;
    }

    function getItemType () {
        if (strpos($this->name, "Q&A") !== false) {
            $this->type = "qa";
        } else if (strpos($this->name, "Study Guide") !== false) {
            $this->type = "study_guide";
        } else {
            $this->type = $this->name;
        }

        return $this->type;
    }
}
