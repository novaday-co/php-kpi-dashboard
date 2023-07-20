<?php

namespace App\Models;

class KPI
{
    public static function getKPIData()
    {
        $jsonData = file_get_contents('./storage/kpi_data.json');
        return json_decode($jsonData, true);
    }

    public static function getMetricData()
    {
        $jsonData = file_get_contents('./storage/metric_data.json');
        return json_decode($jsonData, true);
    }
}
