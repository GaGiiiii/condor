<?php

namespace App\Services\Statistics;

use IStatisticsSource;

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
}
