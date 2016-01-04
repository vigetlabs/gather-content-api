<?php

namespace GatherContent\Model;

class FileCollection
{
    use Collection;

    function forItemId($item_id)
    {
        $response = $this->request_instance->get("items/{$item_id}/files");
        return $this->collect($response, 'File');
    }
}
