<?php

namespace App\Response;

use SimpleXMLElement;

class Response
{
    /**
     * This function accepts array as data and transforms it to JSON or XML.
     *
     * @param array $data = []
     * @param int $statusCode = 200
     */
    public static function generateResponse(array $data = [], int $statusCode = 200)
    {
        $headers = getallheaders();
        $acceptHeader = isset($headers['Accept']) ? $headers['Accept'] : '';

        if ($acceptHeader === 'application/json') {
            return self::formatToJSON($data, $statusCode);
        }

        if ($acceptHeader === 'application/xml') {
            return self::formatToXML($data, $statusCode);
        }

        return self::formatToJSON($data, $statusCode);
    }

    /**
     * This function accepts array as data and transforms it to JSON, and returns provided status code.
     *
     * @param array $data
     * @param int $statusCode
     */
    public static function formatToJSON(array $data, int $statusCode)
    {
        header('Content-Type: application/json');
        http_response_code($statusCode);
        echo json_encode($data);

        exit;
    }

    /**
     * This function accepts array as data and transforms it to XML, and returns provided status code.
     *
     * @param array $data
     * @param int $statusCode
     */
    public static function formatToXML(array $data, int $statusCode)
    {
        header("Content-Type: application/xml");
        http_response_code($statusCode);
        $xml = new SimpleXMLElement('<root/>');
        self::arrayToXML($data, $xml);
        echo $xml->asXML();

        exit;
    }

    /**
     * This is recursive function that transforms array to XML.
     *
     * @param array $array
     * @param &$xml
     * @return void
     */
    private static function arrayToXML(array $array, &$xml): void
    {
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                if (!is_numeric($key)) {
                    $subnode = $xml->addChild("$key");
                    self::arrayToXML($value, $subnode);
                } else {
                    $subnode = $xml->addChild("item$key");
                    self::arrayToXML($value, $subnode);
                }
            } else {
                $xml->addChild("$key", "$value");
            }
        }
    }
}
