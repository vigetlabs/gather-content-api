<?php

namespace GatherContent\Model;

class Template
{
    use Assignable;
    use TabsContainer;

    public $id          = null;
    public $project_id  = null;
    public $created_by  = null;
    public $updated_by  = null;
    public $name        = null;
    public $description = null;
    public $config      = null;

    static function retrieveTemplate($id)
    {
        $request = new Request;
        $response = $request->get("templates/{$id}", []);
        return new Template($response->fetch("data"));
    }

}
