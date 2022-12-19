<?php

namespace App\Services\Statistics;

class PositiveGuysStatistics implements IStatisticsSource
{
    /**
     * Calls the positive guys api to get statistics and returns them.
     *
     * @return int
     */
    public function getData(): int
    {
        // Call positive guys api with cURL, Guzzle
        // Do the logic and return data

        return mt_rand(0, 1000);
    }

    /**
     * Calls the positive guys api to get statistics and returns them.
     *
     * @return int
     */
    public function getDataByDay(): int
    {
        // Call positive guys api with cURL, Guzzle
        // Do the logic and return data

        return mt_rand(0, 1000);
    }

    /**
     * Calls the positive guys api to get statistics and returns them.
     *
     * @return int
     */
    public function getDataByWeek(): int
    {
        // Call positive guys api with cURL, Guzzle
        // Do the logic and return data

        return mt_rand(0, 1000);
    }

    /**
     * Calls the positive guys api to get statistics and returns them.
     *
     * @return int
     */
    public function getDataByMonth(): int
    {
        // Call positive guys api with cURL, Guzzle
        // Do the logic and return data

        return mt_rand(0, 1000);
    }

    /**
     * Calls the positive guys api to get statistics and returns them.
     *
     * @return int
     */
    public function getDataByYear(): int
    {
        // Call positive guys api with cURL, Guzzle
        // Do the logic and return data

        return mt_rand(0, 1000);
    }

    /**
     * Calls the positive guys api to get statistics and returns them.
     *
     * @return int
     */
    public function getDataFromPeriod(string $startDate, string $endDate): int
    {
        // Call positive guys api with cURL, Guzzle
        // Do the logic and return data

        return mt_rand(0, 1000);
    }
}
