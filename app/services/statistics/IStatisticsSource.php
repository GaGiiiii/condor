<?php

namespace App\Services\Statistics;

interface IStatisticsSource
{
    public function getData(): int;
}
