<?php

namespace App\Logger;

class Logger
{
    /**
     * This function logs provided data to specified log file.
     *
     * @param array $data
     * @return void
     */
    public static function log(array $data): void
    {
        $pathToLogFile = dirname(__DIR__, 2) . "/storage/logs/errors.log";
        error_log(print_r($data, true), 3, $pathToLogFile);
    }
}
