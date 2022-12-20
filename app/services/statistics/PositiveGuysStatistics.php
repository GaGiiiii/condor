<?php

namespace App\Services\Statistics;

/**
 * ========= IMPORTANT =========
 *
 * We should implement a small cache system here.
 * Instead of calling positive guy's API every time we should check when was the last call made.
 * If the last call was made in the last 5 minutes we don't need to call positive guy API again.
 * Instead we should take the data from the database cache to save some time.
 * If the last call was made more than 5 minutes ago we should then call positive guy API, get
 * Their response and save that response in database cache.
 */

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
