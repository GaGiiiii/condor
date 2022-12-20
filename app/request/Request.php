<?php

namespace App\Request;

use App\Exceptions\JWTException;
use App\Logger\Logger;
use App\Response\Response;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use stdClass;

class Request
{
    /**
     * This function takes requests body and transforms it to the stdClass.
     *
     * @return stdClass
     */
    public static function generateRequest(): stdClass
    {
        $headers = getallheaders();
        $acceptHeader = $headers['Content-Type'];

        if ($acceptHeader === 'application/json') {
            return self::formatFromJSON();
        }

        if ($acceptHeader === 'application/xml') {
            return self::formatFromXML();
        }

        return self::formatFromJSON();
    }

    /**
     * This function takes data from request and decodes it to JSON.
     *
     * @return stdClass
     */
    public static function formatFromJSON(): stdClass
    {
        $raw_data = file_get_contents('php://input');
        $data = json_decode($raw_data);

        if ($data === null) {
            Response::generateResponse([
                'error' => true,
                'message' => 'Invalid JSON sent, please check your request body.'
            ], 400);
        }

        return $data;
    }

    /**
     * This function takes data from request and decodes it to XML.
     *
     * @return stdClass
     */
    public static function formatFromXML(): stdClass
    {
        $raw_data = file_get_contents('php://input');
        $sxml = @simplexml_load_string($raw_data); // @ - means don't show warnings or errors.

        if ($sxml === false) {
            Response::generateResponse([
                'error' => true,
                'message' => 'Invalid XML sent, please check your request body.'
            ], 400);
        }

        return json_decode(json_encode($sxml));
    }

    /**
     * This function checks if query parameter is present or not.
     *
     * If query parameter is present it will returns its value and if its not
     * Then it will return default value, if default value is provided, if its not
     * Then it will return null.
     *
     * @param string $name
     * @param string $default = null
     * @return string|null
     */
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
