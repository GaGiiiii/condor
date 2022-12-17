<?php

require_once "app/request/Request.php";
require_once "app/response/Response.php";
require_once "app/logger/Logger.php";

use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

class StatisticsController
{
    public function getStatistics()
    {
        $headers = getallheaders();
        $auth_header = $headers['Authorization'] ?? '';

        // Extract the token from the header
        $match = [];
        if (preg_match('/^Bearer (\S+)$/', $auth_header, $match)) {
            $token = $match[1];
        }

        // Decode the token and check if it is valid
        try {
            // Set the secret key for JWT validation
            $secret_key = $_ENV['JWT_SECRET'];

            // Decode the token
            $decoded_token = JWT::decode($token, new Key($secret_key, 'HS256'));

            // Extract the data from the token
            $data = $decoded_token->data;

            echo json_encode([
                'message' => 'Welcome to sat page.'
            ]);
        } catch (\Exception $e) {
            // Return an error if the token is invalid
            Logger::log([$e]);

            Response::formatToJSON([
                'error' => "Invalid token"
            ], 401);
        }
    }
}
