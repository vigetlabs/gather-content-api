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

    function findByName($project_id, $template_name) {
        $filter = function ($t) use ($template_name) { return $t->name == $template_name; };
        return current($this->forProjectId($project_id, $filter));
    }

}
