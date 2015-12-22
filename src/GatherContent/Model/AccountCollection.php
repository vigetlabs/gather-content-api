<?php

namespace GatherContent\Model;

class AccountCollection
{
    use Collection;

    function all()
    {
        $response = $this->request_instance->get('accounts');
        return $this->collect($response, 'Account');
    }

    function findById($id)
    {
        return $this->findBy('id', $id);
    }

    function findByName($name)
    {
        return $this->findBy('name', $name);
    }

    function findBySlug($slug)
    {
        return $this->findBy('slug', $slug);
    }

    private function findBy($attribute, $value)
    {
        $filter  = function($r) use ($attribute, $value) { return $value == $r->$attribute; };
        $matches = array_filter($this->all(), $filter);

        return (count($matches) == 1) ? $matches[0] : null ;
    }

}
