<?php

namespace GatherContent\Model;

class ItemCollection
{
    use Collection;

    function forProjectId($project_id)
    {
        $response = $this->request_instance->get('items', ['project_id' => $project_id]);
        return $this->collect($response, 'Item');
    }
}
?>