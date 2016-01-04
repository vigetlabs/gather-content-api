<?php

namespace GatherContent\Model;

trait Assignable
{
    function __construct($attributes = [])
    {
        $this->setAttributes($attributes);
    }

    function setAttributes($attributes = [])
    {
        foreach ($attributes as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

}