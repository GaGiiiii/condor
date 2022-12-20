<?php

namespace App\Services\Statistics;

use App\Logger\Logger;
use App\Repository\Source\SourceRepository;

class StatisticsService
{
    private SourceRepository $sourceRepository;

    public function __construct(SourceRepository $sourceRepository)
    {
        $this->sourceRepository = $sourceRepository;
    }

    public function getData(string $type = null, $startDate = null, $endDate = null): array
    {
        $data = [];
        $sources = $this->sourceRepository->getAll();

        switch (strtolower($type)) {
            case "day":
                $methodName = "getDataByDay";
                break;
            case "week":
                $methodName = "getDataByWeek";
                break;
            case "month":
                $methodName = "getDataByMonth";
                break;
            case "year":
                $methodName = "getDataByYear";
                break;
            case "period":
                $methodName = "getDataFromPeriod";
                break;
            default:
                $methodName = "getDataByMonth";
        }

        foreach ($sources as $source) {
            $fullNamespace = "\\" . __NAMESPACE__ . "\\";
            $className = $fullNamespace . $source['name'] . "Statistics";

            // Fail silently and log error.
            if (!class_exists($className)) {
                Logger::log([
                    'message' => "Class $className doesn't exist.",
                    'called_in' => "StatisticsService.php @getData()"
                ]);

                continue;
            }

            // Fail silently and log error.
            if (!method_exists($className, $methodName)) {
                Logger::log([
                    'message' => "Method $methodName() doesn't exist in class $className.",
                    'called_in' => "StatisticsService.php @getData()"
                ]);

                continue;
            }

            if ($type === 'period') {
                $data[$source['name']] = (new $className())->$methodName($startDate, $endDate);

                continue;
            }

            $data[$source['name']] = (new $className())->$methodName();
        }

        return $data;
    }
}
