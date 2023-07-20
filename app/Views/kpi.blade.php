<!DOCTYPE html>
<html>
<head>
    <title>KPI Dashboard</title>
    <link rel="stylesheet" href="/public/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.0"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns@3.0.0"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,600&display=swap" rel="stylesheet">
    <script>
        @foreach ($groupedData as $metric => $data)
        var {{ str_replace(' ','_',$metric) }}_dates = {!! json_encode(array_column($data, 'measurement_day')) !!}.map(function(date) {
            return new Date(date).toLocaleDateString("{{$localeDateString}}");
        });
        @endforeach
        var chartConfig = {!! str_replace("~\"",'',str_replace("\"~",'',$chartConfig)) !!};
    </script>
</head>
<body>
    <div class="container">
        <h1>{{ $companyName }} KPI Dashboard</h1>
        <div class="kpi-grid">
            @foreach ($groupedData as $metric => $data)
                <div class="kpi-column">
                    <h2>{{ ucfirst($metric) }}</h2>
                    <canvas id="{{ str_replace(' ','_',$metric) }}_chart" width="400" height="200"></canvas>
                    <script>
                        var {{ str_replace(' ','_',$metric) }}_chartCtx = document.getElementById('{{ str_replace(' ','_',$metric) }}_chart').getContext('2d');
                        var {{ str_replace(' ','_',$metric) }}_chart = new Chart({{ str_replace(' ','_',$metric) }}_chartCtx, chartConfig.{{ str_replace(' ','_',$metric) }});
                    </script>
                </div>
            @endforeach
        </div>
    </div>
</body>
</html>
