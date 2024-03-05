@extends('layouts.app', [
'class' => 'sidebar-mini ',
'namePage' => 'Calibration History',
'activePage' => 'calibration_history',
'activeNav' => '',
])

@section('content')
    <div class="panel-header-sm"></div>
    <div class="content">
        <div class="row">
            <div class="col-md-12" id="users-table">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Calibration Frequency</h4>

                        <hr>
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
                            <div id="autoCloseAlert" class="alert alert-success alert-dismissible fade show mx-auto">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <p>{{ $message }}</p>
                            </div>
                            <script>
                                // Auto close the alert after 20 seconds
                                setTimeout(function() {
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

                        <div class="col-12 mt-2"></div>
                        <br>
                    </div>

                    <div class="card-body" style="padding-top:0px;">
                        <div class="tab-content mt-n3">

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
                                    <table id="calHistory" class="table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead class="text-center" style="font-size: 12px;">
                                        <tr>
                                            <th>No</th>
                                            <th>No Control</th>
                                            <th>Device Name</th>
                                            <th>Result</th>
                                            <th>Expired Date</th>
                                            <th class="disabled-sorting notexport">Actions</th>
                                        </tr>
                                        </thead>

                                        <tbody style="font-size: 11px;">
                                        @if (!empty($measuring_device) && $measuring_device->count())
                                            @foreach ($measuring_device as $key => $value)
                                                <tr>
                                                    <td class="text-center">{{ $loop->iteration }}</td>
                                                    <td>{{ $value->no_control }}</td>
                                                    <td>{{ $value->freq->device_name }}</td>

                                                    @php
                                                        $latestCalibration = \App\Models\Calibration::where('measuring_device_id', $value->id)->latest()->first();
                                                    @endphp

                                                    <td>{{ $latestCalibration ? $latestCalibration->result : 'No Calibration Data' }}</td>
                                                    <td>{{ $latestCalibration ? $latestCalibration->expired_date : 'No Expired Data Data' }}</td>
                                                    <td class="text-center">
                                                        <a href="{{ route('calibration_history.print', ['id' => $value->id]) }}" class="btn btn-success btn-icon btn-sm">
                                                            <i class="now-ui-icons files_paper"></i>
                                                        </a>
                                                        <a href="{{ route('export.calibration', $value->id) }}" class="btn btn-danger btn-icon btn-sm">
                                                            <i class="now-ui-icons arrows-1_cloud-download-93"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="6" class="text-center">No data available</td>
                                            </tr>
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
    <!-- Add Frequency modal -->
    <!-- Script untuk memuat DataTables -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#calHistory').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
            });
        });
    </script>
@endsection
