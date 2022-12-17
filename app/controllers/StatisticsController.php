<?php

class StatisticsController
{
    public function getStatistics()
    {
        echo json_encode([
            'message' => 'Welcome to sat page.'
        ]);
    }
}
