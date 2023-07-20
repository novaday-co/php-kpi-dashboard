<?php

namespace App\Controllers;

use App\Models\KPI;

use function PHPSTORM_META\map;

class KPIController extends Controller
{
    public function getGroupedKPIData()
    {
        $kpiData = KPI::getData();
        $groupedData = [];

        // Group the data by metric names
        foreach ($kpiData as $item) {
            $item['measurement_day'] = date('Y-m-d', strtotime($item['measurement_day']));
            $metric = $item['metric'];
            $groupedData[$metric][] = $item;
        }

        $companyName = $_ENV['CompanyName']; 
        $localeDateString = $_ENV['LocaleDateString']; 
        $chartConfig = $this->generateChartConfig($groupedData);
        $html = $this->view->make('kpi', compact('groupedData', 'companyName', 'localeDateString', 'chartConfig'))->render();

        echo $html;
    }

    private function generateChartConfig($groupedData)
    {
        $chartConfigs = [];

        // Loop through each metric and build the Chart.js configuration
        foreach ($groupedData as $metric => $data) {

            // Assuming $metric is the metric name
            $variableName = "~".str_replace(' ', '_', $metric) . '_dates'."~";

            $chartConfig = [
                'type' => 'line',
                'data' => [
                    'labels' => $variableName,
                    'datasets' => [
                        [
                            'label' => $metric,
                            'data' => array_column($data, 'value'),
                            'borderColor' => 'rgba(75, 192, 192, 1)',
                            'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                            'borderWidth' => 1,
                            'pointStyle' => 'circle',
                            'pointRadius' => 5,
                            'pointBackgroundColor' => 'rgba(75, 192, 192, 1)',
                            'pointBorderColor' => 'rgba(255, 255, 255, 1)',
                            'pointBorderWidth' => 2,
                        ],
                    ],
                ],
                'options' => [
                    'scales' => [
                        'x' => [
                           'beginAtZero' => true,
                        ],
                        'y' => [
                            'beginAtZero' => true,
                        ],
                    ],
                ],
            ];

            $chartConfigs[str_replace(' ', '_', $metric)] = $chartConfig;
        }

        return json_encode($chartConfigs, JSON_UNESCAPED_UNICODE);
    }
}