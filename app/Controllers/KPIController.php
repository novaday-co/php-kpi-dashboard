<?php

namespace App\Controllers;

use App\Models\KPI;

use function PHPSTORM_META\map;

class KPIController extends Controller
{
    public function getGroupedKPIData()
    {
        $kpiData = KPI::getKPIData();
        $groupedData = [];

        // Group the data by metric names
        foreach ($kpiData as $item) {
            if(($_SESSION['role'] == 'superadmin') || ($_SESSION['role'] == 'admin' && $_SESSION['role'] == $this->findMetricRole($item['metric']))){
                $item['measurement_day'] = date('Y-m-d', strtotime($item['measurement_day']));
                $metric = $item['metric'];
                $groupedData[$metric][] = $item;
            }
        }

        // Calculate the trend for each metric
        foreach ($groupedData as $metric => &$data) {
            $firstValue = $data[0]['value'];
            $lastValue = end($data)['value'];

            if ($firstValue < $lastValue) {
                // Ascending trend for the metric
                $trend = 'ascending';
            } elseif ($firstValue > $lastValue) {
                // Descending trend for the metric
                $trend = 'descending';
            } else {
                // Flat or no trend for the metric
                $trend = 'flat';
            }

            // Add the calculated trend to all data items for the metric
            foreach ($data as &$item) {
                $item['actual_trend'] = $trend;
            }
        }

        $companyName = $_ENV['CompanyName']; 
        $localeDateString = $_ENV['LocaleDateString']; 
        $chartConfig = $this->generateChartConfig($groupedData);
        $html = $this->view->make('kpi', compact('groupedData', 'companyName', 'localeDateString', 'chartConfig'))->render();

        echo $html;
    }

    private function findMetricTrend($metric){
        $metricData = KPI::getMetricData();
        $foundMetric = null;
            foreach ($metricData as $m) {
                if ($m['name'] === $metric) {
                    $foundMetric = $m;
                    break;
                }
            }

            if ($foundMetric) {
                $trend = $foundMetric['trend'];
            } else {
                $trend = "ascending";
            }

            return $trend;
    }

    private function findMetricRole($metric){
        $metricData = KPI::getMetricData();
        $foundMetric = null;
            foreach ($metricData as $m) {
                if ($m['name'] === $metric) {
                    $foundMetric = $m;
                    break;
                }
            }

            if ($foundMetric) {
                $role = $foundMetric['role'];
            } else {
                $role = "admin";
            }

            return $role;
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
                            'borderWidth' => 1,
                            'pointStyle' => 'circle',
                            'pointRadius' => 5,
                            'pointBorderColor' => 'rgba(255, 255, 255, 1)',
                            'pointBorderWidth' => 2,
                            'pointHoverRadius' => 5,
                            'pointHoverBorderWidth' => 2,
                            // Set colors based on trend
                            'borderColor' => $this->getBorderColor($this->findMetricTrend($metric),$data[0]['actual_trend']),
                            'backgroundColor' => $this->getBackgroundColor($this->findMetricTrend($metric),$data[0]['actual_trend']),
                            'pointBackgroundColor' => $this->getPointBackgroundColor($this->findMetricTrend($metric),$data[0]['actual_trend']),
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

    private function getBorderColor($main_trend, $actual_trend)
    {
        if ($main_trend ==  $actual_trend) {
            return 'rgba(0, 128, 0, 1)';
        } else{
            return 'rgba(255, 0, 0, 1)';
        }
    }

    private function getBackgroundColor($main_trend, $actual_trend)
    {
        if ($main_trend ==  $actual_trend) {
            return 'rgba(0, 128, 0, 0.2)';
        } else{
            return 'rgba(255, 0, 0, 0.2)';
        }
    }

    private function getPointBackgroundColor($main_trend, $actual_trend)
    {
        if ($main_trend ==  $actual_trend) {
            return 'rgba(0, 128, 0, 1)';
        } else{
            return 'rgba(255, 0, 0, 1)';
        }
    }
}