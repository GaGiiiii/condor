<?php

namespace App\Controllers;

use App\Logger\Logger;
use App\Repository\Source\SourceRepository;
use App\Response\Response;
use App\Services\Statistics\StatisticsService;
use Firebase\JWT\ExpiredException;
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

class StatisticsController
{
    public function getStatistics()
    {
        /*
        WE DON'T NEED TO DO ANY OF THESE CHECKS FOR TOKEN,
        WE ONLY NEED TO DO THIS IF WE WANT TO CHECK IF USER IS AUTHORIZED
        TO DO THIS ACTION, HE IS MOST DEFINITELY AUTHENTICATED SINCE THIS IS
        HANDLED IN THE ROUTER!!!!!!
        */
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

            $responseData = [
                'data' => (new StatisticsService(new SourceRepository()))->getData(),
                'message' => "Statistics returned successfully."
            ];

            Response::formatToJSON($responseData);
        } catch (\InvalidArgumentException $e) {
            Logger::log([$e]);

            Response::formatToJSON([
                'error' => true,
                'message' => "Server error"
            ], 500);
        } catch (\DomainException $e) {
            Logger::log([$e]);

            Response::formatToJSON([
                'error' => true,
                'message' => "Invalid token (domain)"
            ], 500);
        } catch (ExpiredException $e) {
            Logger::log([$e]);

            Response::formatToJSON([
                'error' => true,
                'message' => "Invalid token (expired)"
            ], 401);
        } catch (\UnexpectedValueException $e) {
            Logger::log([$e]);

            Response::formatToJSON([
                'error' => true,
                'message' => "Invalid token (value)"
            ], 401);
        } catch (\Exception $e) {
            Logger::log([$e]);

            Response::formatToJSON([
                'error' => true,
                'message' => "Server error"
            ], 500);
        }
    }
}
