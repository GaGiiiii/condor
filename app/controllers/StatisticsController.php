<?php

namespace App\Controllers;

use App\Logger\Logger;
use App\Response\Response;
use App\Services\Statistics\StatisticsService;
use Firebase\JWT\ExpiredException;
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

            Response::formatToJSON((new StatisticsService())->getData());
        } catch (\InvalidArgumentException $e) {
            Logger::log([$e]);

            Response::formatToJSON([
                'error' => "Server error"
            ], 500);
        } catch (\DomainException $e) {
            Logger::log([$e]);

            Response::formatToJSON([
                'error' => "Server error"
            ], 500);
        } catch (ExpiredException $e) {
            Logger::log([$e]);

            Response::formatToJSON([
                'error' => "Invalid token (expired)"
            ], 401);
        } catch (\UnexpectedValueException $e) {
            Logger::log([$e]);

            Response::formatToJSON([
                'error' => "Invalid token"
            ], 401);
        } catch (\Exception $e) {
            Logger::log([$e]);

            Response::formatToJSON([
                'error' => "Server error"
            ], 500);
        }
    }
}
