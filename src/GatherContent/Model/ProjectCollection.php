<?php

namespace GatherContent\Model;

class ProjectCollection
{
    use Collection;

    function forAccountId($account_id)
    {
        $response = $this->request_instance->get('projects', ['account_id' => $account_id]);
        return $this->collect($response, 'Project');
    }

}