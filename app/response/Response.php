<?php

namespace App\Response;

class Response
{
    /**
     * This function accepts array as data and transforms it to JSON, and returns provided status code.
     *
     * @param array $data = []
     * @param int $statusCode = 200 
     */
    public static function formatToJSON(array $data = [], int $statusCode = 200)
    {
        header('Content-Type: application/json');
        http_response_code($statusCode);
        echo json_encode($data);

        exit;
    }
}
