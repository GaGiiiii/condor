<?php

namespace App\Services\Statistics;

class DatabaseStatistics implements IStatisticsSource
{
    /**
     * Calls the database to get statistics and returns them.
     *
     * @return int
     */
    public function getDataByDay(): int
    {
        // Call database and get data
        // Do the logic and return data

        return mt_rand(0, 1000);
    }

    /**
     * Calls the database to get statistics and returns them.
     *
     * @return int
     */
    public function getDataByWeek(): int
    {
        // Call database and get data
        // Do the logic and return data

        return mt_rand(0, 1000);
    }

    /**
     * Calls the database to get statistics and returns them.
     *
     * @return int
     */
    public function getDataByMonth(): int
    {
        // Call database and get data
        // Do the logic and return data

        return mt_rand(0, 1000);
    }

    /**
     * Calls the database to get statistics and returns them.
     *
     * @return int
     */
    public function getDataByYear(): int
    {
        // Call database and get data
        // Do the logic and return data

        return mt_rand(0, 1000);
    }

    /**
     * Calls the database to get statistics and returns them.
     *
     * @return int
     */
    public function getDataFromPeriod(string $startDate, string $endDate): int
    {
        // Call database and get data
        // Do the logic and return data

        return mt_rand(0, 1000);
    }
}
