<?php

namespace GatherContent\Model;

trait Assignable
{
    function __construct($attributes = [])
    {
        foreach ($attributes as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

}