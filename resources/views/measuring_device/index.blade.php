@extends('layouts.app', [
    'class' => 'sidebar-mini ',
    'namePage' => 'Measuring Device Management',
    'activePage' => 'measuring_device',
    'activeNav' => '',
])

@section('content')
    <div class="panel-header-sm"></div>
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        @if(Auth::check() && Auth::user()->roles === 'Admin')
                            <a class="btn btn-primary btn-round text-white pull-right font-weight-bold"
                               data-toggle="modal"
                               data-target="#createMeasuringDevice" href="#"
                               style="font-size: 12px; background-color: #1a7fcd">
                                <i class="now-ui-icons ui-1_simple-add mr-2"></i> Add Device
                            </a>
                        @endif
                        <h4 class="card-title font-weight-bold">Measuring Device</h4>
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
                            <div class="alert alert-danger">
                                <strong>Error</strong><br><br>
                                <p>{{ session('error')['message'] }}</p>

                            </div>
                        @endif

                        <div class="col-12 mt-2"></div>
                    </div>
                    @include('measuring_device.create')

                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="measuringDevice" class="table table-striped table-bordered" cellspacing="0"
                                   width="100%">
                                <thead class="text-center" style="font-size: 8px;">
                                <tr>
                                    <th>No</th>
                                    <th>No Control</th>
                                    <th>Device Name</th>
                                    <th>Type</th>
                                    <th>Merk</th>
                                    <th>No Seri</th>
                                    <th>Range</th>
                                    <th>Resolution</th>
                                    <th>ATA SAI</th>
                                    <th>Inv No</th>
                                    <th>No Doc BC</th>
                                    <th class="disabled-sorting notexport">Actions</th>
                                </tr>
                                </thead>
                                <tbody style="font-size: 10px;">
                                @if (!empty($measuring_device) && $measuring_device->count())
                                    @foreach ($measuring_device as $key => $value)
                                        <tr>
                                            <td class="text-center">
                                                {{ $loop->iteration}}
                                            </td>
                                            <td>{{ $value->no_control }}</td>
                                            <td>{{ $value->freq->device_name }}</td>
                                            <td>{{ $value->type->type }}</td>
                                            <td>{{ $value->merk->merk }}</td>
                                            <td>{{ $value->no_seri }}</td>
                                            <td>{{ $value->range->range }}</td>
                                            <td>{{ $value->resolution->resolution }}</td>
                                            <td>{{ $value->ata_sai }}</td>
                                            <td>{{ $value->inv_no }}</td>
                                            <td>{{ $value->no_doc_bc }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>

                        @foreach($measuring_device as $key => $value)
                            <div class="modal fade" id="deleteMeasuringDevice{{ $value->id }}" tabindex="-1"
                                 role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle">Delete Measuring
                                                Device</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="POST"
                                                  action="{{ route('measuring_devices.destroy', $value->id) }}"
                                                  enctype="multipart/form-data">
                                                @csrf
                                                @method('DELETE')
                                                <div class="modal-body">Are you sure to delete this device with number
                                                    control
                                                    <br>
                                                    <b>{{ $value->no_control }} - {{ $value->freq->device_name }}</b>?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Cancel
                                                    </button>
                                                    <button type="submit" class="btn btn-danger">Delete Device</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <br>
                    </div>
                    <!-- end content-->
                </div>
                <!--  end card  -->

            </div>
            <!-- end col-md-12 -->
        </div>
        <!-- end row -->
    </div>
    @include('layouts.footer')
    <!-- Script untuk memuat DataTables -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#measuringDevice').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "{{ route('measuring_device_json.data') }}",
                "columns": [
                    {
                        "data": null,
                        "name": "id",
                        "render": function (data, type, row, meta) {
                            return meta.row + 1;
                        }
                    },
                    {"data": "no_control", "name": "no_control"},
                    {
                        "data": "freq",
                        "name": "freq.device_name",
                        "render": function (data, type, row) {
                            return data.device_name;
                        }
                    },
                    {
                        "data": "type",
                        "name": "type.type",
                        "render": function (data, type, row) {
                            return data.type;
                        }
                    },
                    {
                        "data": "merk",
                        "name": "merk.merk",
                        "render": function (data, type, row) {
                            return data.merk;
                        }
                    },
                    {"data": "no_seri", "name": "no_seri"},
                    {"data": "range.range", "name": "range.range"},
                    {"data": "resolution.resolution", "name": "resolution.resolution"},
                    {"data": "ata_sai", "name": "ata_sai"},
                    {"data": "inv_no", "name": "inv_no"},
                    {"data": "no_doc_bc", "name": "no_doc_bc"},
                    {
                        "data": null,
                        "name": "actions",
                        "orderable": false,
                        "searchable": false,
                        "render": function (data, type, row) {
                            return '<button type="button" class="btn btn-success btn-icon btn-sm" data-toggle="modal" data-target="#editMeasuringDevice' + row.id + '"><i class="fas fa-pencil-alt"></i></button>' +
                                '<button type="button" class="btn btn-danger btn-icon btn-sm deleteBtn" data-toggle="modal" data-target="#deleteMeasuringDevice' + row.id + '"><i class="fas fa-trash-alt"></i></button>';
                        }
                    },
                ],
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                "order": [[0, 'asc']], // Default sorting by ID
            });

            // Event handler untuk tombol edit
            $(document).on('click', '.editBtn', function () {
                var id = $(this).data('id');
                var modalSelector = '#editMeasuringDevice' + id;
                $(modalSelector).modal('show');
            });
        });
    </script>

@endsection

