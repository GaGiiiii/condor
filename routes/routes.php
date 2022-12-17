<?php

//(\d+) instead of ID

// Define an array of routes
$routes = [
    '/' => [
        'GET' => 'HomeController@index',
    ],

    '/users' => [
        'GET' => 'UsersController@index',
    ],

    '/users/(\d+)' => [
        'GET' => 'UsersController@show',
    ],
];
