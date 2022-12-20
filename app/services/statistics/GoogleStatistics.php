<?php

namespace App\Services\Statistics;

use App\Logger\Logger;
use App\Repository\Source\SourceRepository;

/**
 * ========= IMPORTANT =========
 *
 * We should implement a small cache system here.
 * Instead of calling google's API every time we should check when was the last call made.
 * If the last call was made in the last 5 minutes we don't need to call google API again.
 * Instead we should take the data from the database cache to save some time.
 * If the last call was made more than 5 minutes ago we should then call google API, get
 * Their response and save that response in database cache.
 *
 * Database table should contain TIMESTAMP of the last call to the API as well as the name of the SERVICE
 * And the TYPE (day, week, month, year, period). In case of the period we should always call google API.
 */

class GoogleStatistics implements IStatisticsSource
{
    private SourceRepository $sourceRepository;

    public function __construct(SourceRepository $sourceRepository)
    {
        $this->sourceRepository = $sourceRepository;
    }

    /**
     * Calls the google api to get statistics and returns them.
     *
     * @return int
     */
    public function getDataByDay(): int
    {
        $name = 'Google';
        $type = 'day';
        $lastCall = $this->sourceRepository->getLastAPICall($name, $type);

        // It doesn't exist in the table.
        if ($lastCall === false) {
            // Call google api with cURL, Guzzle
            // Do the logic and return data
            // Save in DB
            $valueFromGoogle = mt_rand(0, 1000);

            $this->sourceRepository->insertLastAPICall([
                'source_name' => $name,
                'called_at' => date("Y-m-d H:i:s"),
                'type' => $type,
                'latest_data' => $valueFromGoogle
            ]);

            return $valueFromGoogle;
        }

        // PDO Exception in repository, call google but don't update in DB.
        if ($lastCall === null) {
            // Call google api with cURL, Guzzle
            // Do the logic and return data
            // Save in DB
            $valueFromGoogle = mt_rand(0, 1000);

            return $valueFromGoogle;
        }

        // If last call was made before last 5 minutes, call google and update database.
        if ($this->isDateBefore5Minutes($lastCall)) {
            // Call google api with cURL, Guzzle
            // Do the logic and return data
            // Save in DB
            $valueFromGoogle = mt_rand(0, 1000);

            $this->sourceRepository->updateLastAPICall($lastCall['id'], [
                'source_name' => $name,
                'called_at' => date("Y-m-d H:i:s"),
                'type' => $type,
                'latest_data' => $valueFromGoogle
            ]);

            return $valueFromGoogle;
        }

        return $lastCall['latest_data'];
    }

    /**
     * Calls the google api to get statistics and returns them.
     *
     * @return int
     */
    public function getDataByWeek(): int
    {
        $name = 'Google';
        $type = 'week';
        $lastCall = $this->sourceRepository->getLastAPICall($name, $type);

        // It doesn't exist in the table.
        if ($lastCall === false) {
            // Call google api with cURL, Guzzle
            // Do the logic and return data
            // Save in DB
            $valueFromGoogle = mt_rand(0, 1000);

            $this->sourceRepository->insertLastAPICall([
                'source_name' => $name,
                'called_at' => date("Y-m-d H:i:s"),
                'type' => $type,
                'latest_data' => $valueFromGoogle
            ]);

            return $valueFromGoogle;
        }

        // PDO Exception in repository, call google but don't update in DB.
        if ($lastCall === null) {
            // Call google api with cURL, Guzzle
            // Do the logic and return data
            // Save in DB
            $valueFromGoogle = mt_rand(0, 1000);

            return $valueFromGoogle;
        }

        // If last call was made before last 5 minutes, call google and update database.
        if ($this->isDateBefore5Minutes($lastCall)) {
            // Call google api with cURL, Guzzle
            // Do the logic and return data
            // Save in DB
            $valueFromGoogle = mt_rand(0, 1000);

            $this->sourceRepository->updateLastAPICall($lastCall['id'], [
                'source_name' => $name,
                'called_at' => date("Y-m-d H:i:s"),
                'type' => $type,
                'latest_data' => $valueFromGoogle
            ]);

            return $valueFromGoogle;
        }

        return $lastCall['latest_data'];
    }

    /**
     * Calls the google api to get statistics and returns them.
     *
     * @return int
     */
    public function getDataByMonth(): int
    {
        $name = 'Google';
        $type = 'month';
        $lastCall = $this->sourceRepository->getLastAPICall($name, $type);

        // It doesn't exist in the table.
        if ($lastCall === false) {
            // Call google api with cURL, Guzzle
            // Do the logic and return data
            // Save in DB
            $valueFromGoogle = mt_rand(0, 1000);

            $this->sourceRepository->insertLastAPICall([
                'source_name' => $name,
                'called_at' => date("Y-m-d H:i:s"),
                'type' => $type,
                'latest_data' => $valueFromGoogle
            ]);

            return $valueFromGoogle;
        }

        // PDO Exception in repository, call google but don't update in DB.
        if ($lastCall === null) {
            // Call google api with cURL, Guzzle
            // Do the logic and return data
            // Save in DB
            $valueFromGoogle = mt_rand(0, 1000);

            return $valueFromGoogle;
        }

        // If last call was made before last 5 minutes, call google and update database.
        if ($this->isDateBefore5Minutes($lastCall)) {
            // Call google api with cURL, Guzzle
            // Do the logic and return data
            // Save in DB
            $valueFromGoogle = mt_rand(0, 1000);

            $this->sourceRepository->updateLastAPICall($lastCall['id'], [
                'source_name' => $name,
                'called_at' => date("Y-m-d H:i:s"),
                'type' => $type,
                'latest_data' => $valueFromGoogle
            ]);

            return $valueFromGoogle;
        }

        return $lastCall['latest_data'];
    }

    /**
     * Calls the google api to get statistics and returns them.
     *
     * @return int
     */
    public function getDataByYear(): int
    {
        $name = 'Google';
        $type = 'year';
        $lastCall = $this->sourceRepository->getLastAPICall($name, $type);

        // It doesn't exist in the table.
        if ($lastCall === false) {
            // Call google api with cURL, Guzzle
            // Do the logic and return data
            // Save in DB
            $valueFromGoogle = mt_rand(0, 1000);

            $this->sourceRepository->insertLastAPICall([
                'source_name' => $name,
                'called_at' => date("Y-m-d H:i:s"),
                'type' => $type,
                'latest_data' => $valueFromGoogle
            ]);

            return $valueFromGoogle;
        }

        // PDO Exception in repository, call google but don't update in DB.
        if ($lastCall === null) {
            // Call google api with cURL, Guzzle
            // Do the logic and return data
            // Save in DB
            $valueFromGoogle = mt_rand(0, 1000);

            return $valueFromGoogle;
        }

        // If last call was made before last 5 minutes, call google and update database.
        if ($this->isDateBefore5Minutes($lastCall)) {
            // Call google api with cURL, Guzzle
            // Do the logic and return data
            // Save in DB
            $valueFromGoogle = mt_rand(0, 1000);

            $this->sourceRepository->updateLastAPICall($lastCall['id'], [
                'source_name' => $name,
                'called_at' => date("Y-m-d H:i:s"),
                'type' => $type,
                'latest_data' => $valueFromGoogle
            ]);

            return $valueFromGoogle;
        }

        return $lastCall['latest_data'];
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

    // MOVE THIS FUNCTION TO TRAIT OR GLOBAL !!!
    private function isDateBefore5Minutes($lastCall): bool
    {
        $date = $lastCall['called_at'];

        // Convert the date to a Unix timestamp
        $dateTimestamp = strtotime($date);

        // Get the current Unix timestamp
        $currentTimestamp = time();

        // Calculate the difference in seconds between the two timestamps
        $difference = $currentTimestamp - $dateTimestamp;

        // If the difference is less than 300 seconds (five minutes), the date is within five minutes

        return $difference >= 300;
    }
}
