<?php

namespace App\Controllers;

use App\Response\Response;

class UsersController
{
    /**
     * This function returns all users.
     */
    public function index()
    {
        Response::generateResponse([
            'message' => "Returns all users."
        ]);
    }

    /**
     * This function returns user with specific ID.
     */
    public function show($id)
    {
        Response::generateResponse([
            'message' => "Returns user with ID: $id."
        ]);
    }
}
