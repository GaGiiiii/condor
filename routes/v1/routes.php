<?php

//(\d+) instead of ID

// Define an array of routes
$routes = [
    '/' => [
        'GET' => 'App\Controllers\HomeController@index',
    ],

    '/users' => [
        'GET' => 'App\Controllers\UsersController@index',
    ],

    '/users/(\d+)' => [
        'GET' => 'App\Controllers\UsersController@show',
    ],

    '/fetch' => [
        'GET' => 'App\Controllers\StatisticsController@getStatistics',
        'PROTECTED' => true
    ],

    '/login' => [
        'POST' => 'App\Controllers\AuthController@login',
    ],
];

// Add /v1 prefix to routes
foreach ($routes as $key => $value) {
    if ($key != '/') {
        $new_key = "/v1" . $key;
        unset($routes[$key]);
        $routes[$new_key] = $value;
    }
}
