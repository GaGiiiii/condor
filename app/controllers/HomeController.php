<?php

namespace App\Controllers;

class HomeController
{
    public function index()
    {
        echo json_encode([
            'message' => 'Welcome to home page.'
        ]);
    }
}
