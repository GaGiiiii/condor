<?php

namespace App\Services\Statistics;

class GoogleStatistics implements IStatisticsSource
{
    /**
     * Calls the google api to get statistics and returns them.
     *
     * @return int
     */
    public function getDataByDay(): int
    {
        // Call google api with cURL, Guzzle
        // Do the logic and return data

        return mt_rand(0, 1000);
    }

    /**
     * Calls the google api to get statistics and returns them.
     *
     * @return int
     */
    public function getDataByWeek(): int
    {
        // Call google api with cURL, Guzzle
        // Do the logic and return data

        return mt_rand(0, 1000);
    }

    /**
     * Calls the google api to get statistics and returns them.
     *
     * @return int
     */
    public function getDataByMonth(): int
    {
        // Call google api with cURL, Guzzle
        // Do the logic and return data

        return mt_rand(0, 1000);
    }

    /**
     * Calls the google api to get statistics and returns them.
     *
     * @return int
     */
    public function getDataByYear(): int
    {
        // Call google api with cURL, Guzzle
        // Do the logic and return data

        return mt_rand(0, 1000);
    }

    /**
     * Calls the google api to get statistics and returns them.
     *
     * @return int
     */
    public function getDataFromPeriod(string $startDate, string $endDate): int
    {
        // Call google api with cURL, Guzzle
        // Do the logic and return data

        return mt_rand(0, 1000);
    }
}
