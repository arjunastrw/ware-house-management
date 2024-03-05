@extends('layouts.app', [
'namePage' => 'Measuring Device Calibration Frequency',
'class' => 'sidebar-mini ',
'activePage' => 'calibration_frequency',
'activeNav' => '',
])

@section('content')
    <div class="panel-header-sm"></div>
    <div class="content">
        <div class="row">
            <div class="col-md-12" id="users-table">
                <div class="card">
                    <div class="card-header">
                        <!-- button add frequency -->
                            <a class="btn btn-primary btn-round text-white pull-right font-weight-bold"
                               data-toggle="modal"
                               data-target="#createFreq" href="#"
                               style="font-size: 12px; background-color: #168eea">
                                <i class="now-ui-icons ui-1_simple-add mr-2"></i>Add Calibration Frequency
                            </a>

                        <h4 class="card-title">Calibration Frequency</h4>

                        <hr>

                        <div class="col-12 mt-2"></div>
                        <br>
                    </div>

                    <div class="card-body" style="padding-top:0px;">
                        <!-- Tab content -->
                        <div class="tab-content mt-n3">

                            <!-- Frequency Section -->
                            <div class="tab-pane fade show active" id="freqSection">
                                @if(session('measuring_success'))
                                    <script>
                                        nowuiDashboard.showNotification('top', 'right', "{{ session('measuring_success') }}", 'success');
                                    </script>
                                @endif

                                @if(session('measuring_error'))
                                    <script>
                                        nowuiDashboard.showNotification('top', 'right', "{{ session('measuring_error')['message'] }}", 'danger');
                                    </script>
                                @endif

                                @if ($message = Session::get('success'))
                                    <div id="autoCloseAlert"
                                         class="alert alert-success alert-dismissible fade show mx-auto">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <p>{{ $message }}</p>
                                    </div>
                                    <script>
                                        // Auto close the alert after 20 seconds
                                        setTimeout(function () {
                                            $('#autoCloseAlert').alert('close');
                                        }, 20000);
                                    </script>
                                @elseif (session('error'))
                                    <div class="alert alert-danger alert-dismissible fade show mx-auto">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <p>{{ session('error')['message'] }}</p>
                                    </div>
                                @endif
                                <!-- Add Frequency button -->
                                <div class="table-responsive">
                                    <table id="freqCal" class="table-striped table-bordered" cellspacing="0"
                                           width="100%">
                                        <!-- Table structure for Frequency section -->
                                        <thead class="text-center" style="font-size: 12px;">
                                        <tr>
                                            <th>No</th>
                                            <th>Device Name</th>
                                            <th>Status</th>
                                            <th>Frequency Calibration</th>
                                            <th>Life Time</th>
                                            <th class="disabled-sorting notexport">Actions</th>
                                        </tr>
                                        </thead>

                                        <tbody style="font-size: 11px;">
                                        @if (!empty($freqCals) && $freqCals->count())
                                            @foreach ($freqCals as $key => $value)
                                                <tr>
                                                    <td class="text-center">
                                                        {{ $loop->iteration }}
                                                    </td>
                                                    <td>{{ $value->device_name }}</td>
                                                    <td>{{ $value->cal_status }}</td>
                                                    <td>{{ $value->freq_cal_num }}</td>
                                                    <td>{{ $value->life_time_num }}</td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-success btn-icon btn-sm"
                                                                data-toggle="modal"
                                                                data-target="#editFreq{{ $value->id }}">
                                                            <i class="fas fa-pencil-alt"></i>
                                                        </button>
                                                        @include('freq.edit')
                                                        <button type="button" class="btn btn-danger btn-icon btn-sm"
                                                                data-toggle="modal"
                                                                data-target="#deleteFreq{{ $value->id }}">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </td>
                                                    @include('freq.delete')
                                                </tr>
                                            @endforeach
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- end content-->
                    </div>
                    <!--  end card  -->
                </div>
                <!-- end col-md-12 -->
            </div>
            <!-- end row -->
        </div>
    </div>
    @include('layouts.footer')
    <!-- Script untuk memuat DataTables -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#freqCal').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "{{ route('freq_cal_json.data') }}",
                "columns": [
                    {"data": "id", "name": "id"},
                    {"data": "device_name", "name": "device_name"},
                    {"data": "cal_status", "name": "cal_status"},
                    {"data": "freq_cal_num", "name": "freq_cal_num"},
                    {"data": "life_time_num", "name": "life_time_num"},
                    {
                        "data": null,
                        "name": "actions",
                        "orderable": false,
                        "searchable": false,
                        "render": function (data, type, row) {
                            return '<button type="button" class="btn btn-success btn-icon btn-sm" data-toggle="modal" data-target="#editFreq' + row.id + '"><i class="fas fa-pencil-alt"></i></button>' +
                                '<button type="button" class="btn btn-danger btn-icon btn-sm deleteBtn" data-toggle="modal" data-target="#deleteFreq' + row.id + '"><i class="fas fa-trash-alt"></i></button>';
                        }
                    },
                ],
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                "order": [[0, 'asc']], // Default sorting by ID
            });
        });
    </script>

@endsection
