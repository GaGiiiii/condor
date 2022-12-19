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
        $data = [];
        $sources = $this->sourceRepository->getAll();

        foreach ($sources as $source) {
            $fullNamespace = "\\" . __NAMESPACE__ . "\\";
            $className = $fullNamespace . $source['name'] . "Statistics";
            $data[$source['name']] = (new $className())->getData();
        }

        return $data;
    }
}
