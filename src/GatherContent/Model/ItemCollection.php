<?php

namespace GatherContent\Model;

class ItemCollection
{
    use Collection;

    function forProjectId($project_id, $filter = null)
    {
        $response = $this->request_instance->get('items', ['project_id' => $project_id]);
        $items = $this->collect($response, 'Item');
        if ($filter) {
            return array_filter($items, $filter);
        }

        return $items;
    }
    
    function forItemId($item_id)
    {
        $response = $this->request_instance->get("items/{$item_id}", []);
        return $this->collectKey($response, 'Item');
    }

}
?>