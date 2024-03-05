@extends('layouts.app', [
    'namePage' => 'Dashboard',
    'class' => 'login-page sidebar-mini ',
    'activePage' => 'dashboard',
    'backgroundImage' => asset('assets/img/bg14.jpg'),
])




@section('content')
    <div class="panel-header panel-header-lg">
        <canvas id="bigDashboardChart"></canvas>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="row" style="margin-top: -300px;">
        <div class="col-lg-3">
            <div class="card card-chart"
                 style="border-radius: 25px; height: 235px;  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                <div class="card-header">
                    <h5 class="card-category">Info Calibration</h5>
                    <h4 class="card-title font-weight-bold">Periode</h4>
                </div>
                <form action="{{ route('calibration.export') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <input
                                        style="border-radius: 20px;"
                                        type="month" id="bulan-tahun-1" name="startPeriod"
                                        value="{{ $startPeriod }}" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <input
                                        style="border-radius: 20px;"
                                        type="month" id="bulan-tahun-2" name="endPeriod"
                                        value="{{ $endPeriod }}" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary float-right mt-auto"
                                style="background-color: #2186d3; font-weight: bold; border-radius: 20px;">Download
                        </button>
                    </div>
                </form>
            </div>
        </div>
        {{--            ok--}}
        <div class="col-lg-3 " style="color:white;">
            <div class="card card-chart"
                 style="background-color: rgba(124,250,1, 0.6); border-radius: 100px; height: 120px; cursor: pointer; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                <div class="card-header"
                     style="display: flex; justify-content: flex-start; padding: 0px; margin-left: 36px; margin-top: 10px; color: white;">
                    <div
                        style="background-color: white; border-radius: 50%; width: 50px; height: 50px; display: flex; justify-content: center; align-items: center; margin-top: 25px; margin-left: -20px; margin-right: 20px; color: rgb(124, 250, 1);">
                        <i class="fas fa-check"></i></div>
                    <div>
                        <a style="font-weight: bold; font-size: 38px;"> {{ $okCount }}</a>
                        <h5 class="card-title" style="font-weight: lighter;">Calibration Result OK</h5>
                    </div>
                </div>
            </div>
        </div>
        {{--            nok--}}
        <div class="col-lg-3 " style="color:white;">
            <div class="card card-chart"
                 style="background-color: rgba(255,255,0, 0.8); border-radius: 100px; height: 120px; cursor: pointer;  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                <div class="card-header"
                     style="display: flex; justify-content: flex-start; padding: 0px; margin-left: 36px; margin-top: 10px; color: white;">
                    <div
                        style="background-color: white; border-radius: 50%; width: 50px; height: 50px; display: flex; justify-content: center; align-items: center; margin-top: 25px; margin-left: -20px; margin-right: 20px; color: rgba(255,255,0, 06)">
                        <i class="fas fa-recycle"></i></div>
                    <div>
                        <a style="font-weight: bold; font-size: 38px;"> {{ $nokCount }}</a>
                        <h5 class="card-title" style="font-weight: lighter;">Calibration Result N-OK</h5>
                    </div>
                </div>
            </div>
        </div>
        {{--            scrap--}}
        <div class="col-lg-3 " style="color:white;">
            <div class="card card-chart"
                 style="background-color: rgba(208,47, 47, 0.9); border-radius: 100px; height: 120px; cursor: pointer;  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                <div class="card-header"
                     style="display: flex; justify-content: flex-start; padding: 0px; margin-left: 36px; margin-top: 10px; color: white;">
                    <div
                        style="background-color: white; border-radius: 50%; width: 50px; height: 50px; display: flex; justify-content: center; align-items: center; margin-top: 25px; margin-left: -20px; margin-right: 20px; color: rgba(208,47, 47, 0.9)">
                        <i class="fas fa-trash"></i></div>
                    <div>
                        <a style="font-weight: bold; font-size: 38px;"> {{ $nokScrapCount }}</a>
                        <h5 class="card-title" style="font-weight: lighter;">Calibration Result SCRAP</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div style="display: flex; margin-bottom: 20px;">
        {{--            total calibrations--}}
        <div class="col-lg-3 " style=" margin-left: 500px; margin-top: -120px">
            <div class="card card-chart"
                 style="background-color: rgba(255,255,255); border-radius: 100px; height: 120px; cursor: pointer;  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                <div class="card-header"
                     style="display: flex; justify-content: flex-start; padding: 0px; margin-left: 36px; margin-top: 10px; color: #3499e6;">
                    <div
                        style="background-color: rgb(52,153,230); border-radius: 50%; width: 50px; height: 50px; display: flex; justify-content: center; align-items: center; margin-top: 25px; margin-left: -20px; margin-right: 20px; color: white;">
                        <i class="fas fa-cogs"></i></div>
                    <div>
                        <a style="font-weight: bold; font-size: 38px;"> {{ $totalCalibrations }}</a>
                        <h5 class="card-title" style="font-weight: lighter;margin-left: -5px;">Count
                            Calibrations</h5>
                    </div>
                </div>
            </div>
        </div>
        {{--            total measuring devices--}}
        <div class="col-lg-3 " style=" margin-left: 20px; margin-top: -120px">
            <div class="card card-chart"
                 style="background-color: rgba(255,255,255); border-radius: 100px; height: 120px; cursor: pointer;  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                <div class="card-header"
                     style="display: flex; justify-content: flex-start; padding: 0px; margin-left: 36px; margin-top: 10px; color: #3499e6;">
                    <div
                        style="background-color: rgb(52,153,230); border-radius: 50%; width: 50px; height: 50px; display: flex; justify-content: center; align-items: center; margin-top: 25px; margin-left: -20px; margin-right: 20px; color: white;">
                        <i class="fas fa-balance-scale"></i></div>
                    <div>
                        <a style="font-weight: bold; font-size: 38px;"> {{ $totalMeasuringDevice }}</a>
                        <h5 class="card-title" style="font-weight: lighter;margin-left: -5px;">Count Measuring
                            Devices</h5>
                    </div>
                </div>
            </div>
        </div>


    </div>







    {{--        reminder--}}
    <div class="row">
        <div class="col-md-12">
            <div class="card card-tasks"
                 style="height: 350px; border-radius: 10px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                <div class="card-header">
                    <div style="display: flex; justify-content: flex-start; gap: 20px">
                        <h4 class="card-category">Time to Calibrate</h4>
                        <div
                            style="background-color: black; border-radius: 50%; width: 30px; height: 30px; display: flex; justify-content: center; align-items: center; margin-top: -5px;">
                            <a style="color: white">{{ count($upcomingReminders) + count($expiredReminders) }}</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        @if(count($upcomingReminders) > 0 || count($expiredReminders) > 0)
                            <div style="width: 50%;">
                                <h4 class="card-title" style="font-weight: bold;">Upcoming Expired Reminder</h4>
                                <div class="table-responsive" style="max-height: 500px; overflow-y:auto;">
                                    <!-- Table for upcoming reminders -->
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th style="text-align: left;">No</th>
                                            <th style="text-align: left;">No Control</th>
                                            <th style="text-align: left;">Device Name</th>
                                            <th style="text-align: left;">Result</th>
                                            <th style="text-align: left;">Expired Date</th>
                                        </tr>
                                        </thead>
                                        <tbody id="table-body">
                                        @foreach ($upcomingReminders as $reminder)
                                            @if ($reminder->max_next_action != 'SCRAP')
                                                <tr>
                                                    <td style="text-align: left;">{{ $loop->iteration }}</td>
                                                    <td style="text-align: left;">{{ $reminder->measuringDevice->no_control }}</td>
                                                    <td style="text-align: left;">{{ $reminder->measuringDevice->freq->device_name }}</td>
                                                    <td style="text-align: left;"
                                                        class="{{ $reminder->max_result === 'OK' ? 'text-success' : 'text-warning' }}">{{ $reminder->max_result }}</td>
                                                    <td style="text-align: left;">{{ \Carbon\Carbon::parse( $reminder->max_expired_date)->format('d-m-Y') }}</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div style="width: 50%;">
                                <h4 class="card-title font-weight-bold">Expired Reminder</h4>
                                <div class="table-responsive" style="max-height: 500px; overflow-y:auto;">
                                    <!-- Table for expired reminders -->
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th style="text-align: left;">No</th>
                                            <th>No Control</th>
                                            <th>Device Name</th>
                                            <th>Result</th>
                                            <th>Expired Date</th>
                                            <!-- Add other table headers if needed -->
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <!-- Display expired reminders -->
                                        @foreach ($expiredReminders as $reminder)
                                            @if ($reminder->max_next_action != 'SCRAP')
                                                <tr>
                                                    <td style="text-align: left;">{{ $loop->iteration }}</td>
                                                    <td>{{ $reminder->measuringDevice->no_control }}</td>
                                                    <td>{{ $reminder->measuringDevice->freq->device_name }}</td>
                                                    <td class="{{ $reminder->max_result === 'OK' ? 'text-success' : 'text-warning' }}">{{ $reminder->max_result }}</td>
                                                    {{-- <td>{{ $reminder->max_next_action }}</td> --}}
                                                    <td style="text-align: left;">{{ \Carbon\Carbon::parse( $reminder->max_expired_date)->format('d-m-Y') }}</td>
                                                    <!-- Add other columns or actions here -->
                                                </tr>
                                            @endif
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @else
                            <div class="col-md-12">
                                <p>Tidak ada perangkat yang memerlukan kalibrasi.</p>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="card-footer">
                    <hr>
{{--                    <div class="stats">--}}
{{--                        <i class="now-ui-icons loader_refresh spin"></i> Updated 3 minutes ago--}}
{{--                    </div>--}}
                </div>
            </div>
        </div>
    </div>

    {{--        chart--}}
    <div
        style="background-color: white; border-radius: 12px; width:30%; height: 50px; display: flex; justify-content: center; align-items: center; margin-bottom: 20px; margin-left: 20px;  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19)">
        <form method="GET" action="{{ route('dashboard') }}" style="display:flex; gap: 10px;">
            <label for="startYear">Start Year:</label>
            <select name="startYear" id="startYear">
                @for ($year = 2015; $year <= date('Y'); $year++)
                    <option value="{{ $year }}" {{ $year == $startYear ? 'selected' : '' }}>
                        {{ $year }}</option>
                @endfor
            </select>
            <label for="endYear">End Year:</label>
            <select name="endYear" id="endYear">
                @for ($year = 2010; $year <= date('Y'); $year++)
                    <option value="{{ $year }}" {{ $year == $endYear ? 'selected' : '' }} >
                        {{ $year }}</option>
                @endfor
            </select>
            <button type="submit" style="border: 0.2px; border-radius: 10px; background-color: #2186d3; color: white;">
                Apply Filter
            </button>
        </form>
    </div>

    <div id="container1"
         style="min-width: 310px; height: 400px; margin: 0 auto; border-radius: 10px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);"></div>
@endsection

@push('js')
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>

    <script>
        $(document).ready(function () {
            // Get the current date
            var currentDate = new Date();

            // Get the current month (0-indexed)
            var currentMonth = currentDate.getMonth() + 1; // Adding 1 to convert to 1-based indexing

            // Define the start and end years based on the current date
            var startYear, endYear;
            if (currentMonth >= 7) { // If the current month is July or later
                startYear = currentDate.getFullYear();
                endYear = startYear + 1;
            } else { // If the current month is before July
                startYear = currentDate.getFullYear() - 1;
                endYear = currentDate.getFullYear();
            }


            $('#startYear').val(startYear);
            $('#endYear').val(endYear);

            // Update end year options based on start year selection
            $('#startYear').change(function () {
                var selectedStartYear = parseInt($(this).val());
                $('#endYear').val(selectedStartYear + 1);
            });

            var data = <?php echo json_encode($data['datasets']); ?>;
            var labels = <?php echo json_encode($data['labels']); ?>;

            Highcharts.chart('container1', {
                chart: {
                    type: 'line'
                },
                title: {
                    text: 'Monthly Calibration Results'
                },
                xAxis: {
                    categories: labels
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Count'
                    },
                    stackLabels: {
                        enabled: true,
                        style: {
                            fontWeight: 'bold',
                            color: (Highcharts.defaultOptions.title.style && Highcharts.defaultOptions.title.style.color) || 'gray'
                        }
                    }
                },
                legend: {
                    align: 'right',
                    x: -30,
                    verticalAlign: 'top',
                    y: 25,
                    floating: true,
                    backgroundColor: Highcharts.defaultOptions.legend.backgroundColor || 'white',
                    borderColor: '#CCC',
                    borderWidth: 1,
                    shadow: false
                },
                tooltip: {
                    headerFormat: '<b>{point.x}</b><br/>',
                    pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
                },
                plotOptions: {
                    line: {
                        stacking: 'normal',
                        dataLabels: {
                            enabled: true
                        }
                    }
                },
                series: data.map(function (dataset) {
                    return {
                        name: dataset.label,
                        data: dataset.data,
                        color: dataset.backgroundColor
                    };
                })
            });
        });
    </script>
@endpush
