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
                Response::formatToJSON([
                    'error' => true,
                    'message' => "Please provide start date and end date query parameters."
                ], 422);
            }

            $responseData = [
                'data' => (new StatisticsService(new SourceRepository()))->getData($type, $startDate, $endDate),
                'type' => $type,
                'message' => "Statistics returned successfully."
            ];

            Response::formatToJSON($responseData);
        } catch (JWTException $e) {
            Response::formatToJSON([
                'error' => true,
                'message' => $e->getMessage()
            ], $e->getCode());
        } catch (\Exception $e) {
            Logger::log([$e]);

            Response::formatToJSON([
                'error' => true,
                'message' => "Server error"
            ], 500);
        }
    }
}
