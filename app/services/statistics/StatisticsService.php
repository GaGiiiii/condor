<?php

namespace App\Services\Statistics;

use App\Repository\Source\SourceRepository;

class StatisticsService
{
    private SourceRepository $sourceRepository;

    public function __construct(SourceRepository $sourceRepository)
    {
        $this->sourceRepository = $sourceRepository;
    }

    public function getData(): array
    {
        $sources = $this->sourceRepository->getAll();

        return $sources;
    }
}
