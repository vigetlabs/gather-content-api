<?php

namespace GatherContent\Model;

class TemplateCollection
{
    use Collection;


    function forProjectId($project_id, $filter = null)
    {
        $response = $this->request_instance->get('templates', ['project_id' => $project_id]);
        $items = $this->collect($response, 'Template');
        if ($filter) {
            return array_filter($items, $filter);
        }

        return $items;
    }

}
