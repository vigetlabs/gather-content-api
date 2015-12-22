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

}
