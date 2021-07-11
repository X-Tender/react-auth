<?php

namespace App\Controllers;

use Slim\Http\Response;
use Slim\Http\ServerRequest as Request;

class ProjectController
{
    public function getProjects(Request $request, Response $response)
    {
        return $response->withJson([
            [
                "id" => 1,
                "name" => "Projekt 1",
            ], [
                "id" => 2,
                "name" => "Projekt 2",
            ], [
                "id" => 3,
                "name" => "Projekt 3",
            ]
        ]);
    }

    public function getProject(Request $request, Response $response, array $args)
    {
        $id = $args["id"];

        return $response->withJson(
            [
                "id" => $id,
                "name" => "Project " . $id,
                "description" => "This is the description for project with the ID " . $id,
            ]
        );
    }
}
