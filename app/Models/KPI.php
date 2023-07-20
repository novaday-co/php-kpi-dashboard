<?php

namespace App\Models;

class KPI
{
    public static function getData()
    {
        $jsonData = file_get_contents('./storage/kpi_data.json');
        return json_decode($jsonData, true);
    }
}
