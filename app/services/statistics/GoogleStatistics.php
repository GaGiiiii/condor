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
 *
 * Database table should contain TIMESTAMP of the last call to the API as well as the name of the SERVICE
 * And the TYPE (day, week, month, year, period). In case of the period we should always call google API.
 */

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
