<?php

namespace GatherContent\Model;

trait TabsContainer
{
    public $tabs            = [];
    public $fields          = [];

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

}
