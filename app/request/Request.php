<?php

class Request
{
    public static function formatFromJSON()
    {
        $raw_data = file_get_contents('php://input');
        $data = json_decode($raw_data);

        return $data;
    }
}
