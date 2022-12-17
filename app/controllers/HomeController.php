<?php

class HomeController
{
    public function index()
    {
        echo json_encode([
            'data' => [
                'gagi' => 'ez'
            ]
        ]);
    }
}
