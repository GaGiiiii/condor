<?php

class DatabaseStatistics implements IStatisticsSource
{

    /**
     * Calls the database to get statistics and returns them.
     *
     * @return int
     */
    public function getData(): int
    {
        // Call google api with cURL, Guzzle
        // Do the logic and return data

        return mt_rand(0, 1000);
    }
}
