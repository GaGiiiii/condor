<?php

namespace App\Request;

use App\Exceptions\JWTException;
use App\Logger\Logger;
use Firebase\JWT\ExpiredException;
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

use stdClass;

class Request
{
    /**
     * This function takes data from request and decodes it.
     *
     * @return stdClass
     */
    public static function formatFromJSON(): stdClass
    {
        $raw_data = file_get_contents('php://input');
        $data = json_decode($raw_data);

        return $data;
    }

    public static function query(string $name, string $default = null): ?string
    {
        return isset($_GET[$name]) ? $_GET[$name] : $default;
    }

    /**
     * This function gets the data from the Authorization header and transforms it to user.
     *
     * @return stdClass
     * @throws JWTException
     */
    public static function user(): stdClass
    {
        try {
            $headers = getallheaders();
            $auth_header = $headers['Authorization'] ?? '';

            // Extract the token from the header
            $match = [];
            if (preg_match('/^Bearer (\S+)$/', $auth_header, $match)) {
                $token = $match[1];
            }

            // Decode the token and check if it is valid
            // Set the secret key for JWT validation
            $secret_key = $_ENV['JWT_SECRET'];

            // Decode the token
            $decoded_token = JWT::decode($token, new Key($secret_key, 'HS256'));

            // Extract the data from the token
            $data = $decoded_token->data;

            return $data;
        } catch (\InvalidArgumentException $e) {
            Logger::log([$e]);

            throw new JWTException('Server error', 500);
        } catch (\DomainException $e) {
            Logger::log([$e]);

            throw new JWTException('Invalid token (domain)', 500);
        } catch (ExpiredException $e) {
            Logger::log([$e]);

            throw new JWTException('Invalid token (expired)', 401);
        } catch (\UnexpectedValueException $e) {
            Logger::log([$e]);

            throw new JWTException('Invalid token (value)', 401);
        }
    }
}
