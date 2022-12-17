<?php

class Response
{
    public static function formatToJSON(array $data)
    {
        header('Content-Type: application/json');

        echo json_encode($data);
    }
}
