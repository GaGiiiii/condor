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

    '/fetch' => [
        'GET' => 'StatisticsController@getStatistics',
    ],

    '/login' => [
        'POST' => 'AuthController@login',
    ],
];


foreach ($routes as $key => $value) {
    if ($key != '/') {
        $new_key = "/v1" . $key;
        unset($routes[$key]);
        $routes[$new_key] = $value;
    }
}
