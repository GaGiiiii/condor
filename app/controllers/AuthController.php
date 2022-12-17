<?php

require_once "app/request/Request.php";
require_once "app/response/Response.php";

use \Firebase\JWT\JWT;

class AuthController
{
    public function login()
    {
        $data = Request::formatFromJSON();

        $payload = [
            'iss' => 'condor.com',
            'iat' => time(),
            'exp' => time() + 3600, // Token expiration time (1 hour)
            'data' => [
                'username' => $data->username,
                // Add any other data you want to store in the token
            ],
        ];

        $secret =  $_ENV['JWT_SECRET'];

        $token = JWT::encode($payload, $secret, 'HS256');

        // Return the token
        return Response::formatToJSON([
            'success' => true,
            'token' => $token,
        ]);
    }

    public function login2()
    {
        $data = Request::formatFromJSON();

        $payload = [
            'iss' => 'condor.com',
            'iat' => time(),
            'exp' => time() + 3600, // Token expiration time (1 hour)
            'data' => [
                'username' => $data->username,
                // Add any other data you want to store in the token
            ],
        ];

        $secret =  $_ENV['JWT_SECRET'];

        $token = JWT::encode($payload, $secret, 'HS256');

        // Return the token
        return Response::formatToJSON([
            'success' => true,
            'token' => $token,
        ]);
    }
}
