<?php

namespace App\Services\Statistics;

interface IStatisticsSource
{
    public function getDataByDay(): int;
    public function getDataByWeek(): int;
    public function getDataByMonth(): int;
    public function getDataByYear(): int;
    public function getDataFromPeriod(string $startDate, string $endDate): int;
}
