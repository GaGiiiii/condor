<?php

namespace App\Controllers;

class UsersController
{
    public function index()
    {
        echo 12;
    }

    public function show($id)
    {
        // Read the user with the given ID
        // Return the user data
        echo $id;
    }

    public function updateAction($id)
    {
        // Update the user with the given ID
        // Return the updated user data
    }

    public function deleteAction($id)
    {
        // Delete the user with the given ID
        // Return a success message
    }
}
