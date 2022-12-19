<?php

namespace App\Controllers;

use App\Response\Response;

class HomeController
{
    public function index()
    {
        Response::generateResponse([
            'message' => 'Welcome to home page.'
        ]);
    }
}
