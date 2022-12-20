<?php

namespace App\Controllers;

use App\Exceptions\JWTException;
use App\Logger\Logger;
use App\Repository\Source\SourceRepository;
use App\Request\Request;
use App\Response\Response;
use App\Services\Statistics\StatisticsService;

class StatisticsController
{
    /**
     * This function returns statistics for number of visits on clients site.
     *
     * It can accept query parameters. It accepts "type" query parameter.
     * "Type" parameter can have values: day, week, month, year, period.
     * If "type" parameter has value period then client needs to provide
     * "startDate" and "endDate" parameters as well.
     */
    public function getStatistics()
    {
        try {
            // Extract the data from the token
            $data = Request::user();
            $type = Request::query('type', 'month');
            $startDate = Request::query('startDate');
            $endDate = Request::query('endDate');

            // This should be moved from controllers to custom request validation class.
            if (strtolower($type) === 'period' && (!isset($startDate) || !isset($endDate))) {
                Response::generateResponse([
                    'error' => true,
                    'message' => "Please provide start date and end date query parameters."
                ], 422);
            }

            $responseData = [
                'data' => (new StatisticsService(new SourceRepository()))->getData($type, $startDate, $endDate),
                'type' => $type,
                'message' => "Statistics returned successfully."
            ];

            Response::generateResponse($responseData);
        } catch (JWTException $e) {
            Response::generateResponse([
                'error' => true,
                'message' => $e->getMessage()
            ], $e->getCode());
        } catch (\Exception $e) {
            Logger::log([$e]);

            Response::generateResponse([
                'error' => true,
                'message' => "Server error"
            ], 500);
        }
    }
}
