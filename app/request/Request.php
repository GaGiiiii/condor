<?php

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
}
