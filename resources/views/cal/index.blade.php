@extends('layouts.app', [
'class' => 'sidebar-mini ',
'namePage' => 'Calibration',
'activePage' => 'calibration',
'activeNav' => '',
])

@section('content')

    <div class="panel-header-sm">
    </div>
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <a class="btn btn-primary btn-round text-white pull-right" data-toggle="modal" data-target="#"
                           href="#createCalibration"
                           style="font-size: 12px; background-color:#2f94e2; font-weight: bold">
                            <i class="now-ui-icons ui-1_simple-add mr-2"></i> Add Device
                        </a>
                        <h4 class="card-title font-weight-bold">Control Measuring Device</h4>

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
                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
                    @include('cal.create')

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
                                    <table id="cal" class="table-striped table-bordered" cellspacing="0"
                                           width="100%">
                                        <thead class="text-center" style="font-size: 12px;">
                                        <tr>
                                            <th>No</th>
                                            <th>Shift</th>
                                            <th>No Control</th>
                                            <th>Device Name</th>
                                            <th>Calibration Date</th>
                                            <th>No Certificate</th>
                                            <th>Result</th>
                                            <th>Area</th>
                                            <th>Carname</th>
                                            <th>Expired Date</th>
                                            <th>NIK</th>
                                            <th class="disabled-sorting notexport">Actions</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                            @foreach ($calibration as $cal)
                                {{--                                modal edit--}}
                                <div class="modal fade" id="editCalibration{{ $cal->id }}" tabindex="-1" role="dialog"
                                     aria-labelledby=""
                                     aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document"
                                         style="max-width: 1000px; -ms-flex-align: center; text-align: left;
    ">
                                        <div class="modal-content">
                                            <style>
                                                input.form-control {
                                                    border-radius: 5px;
                                                    /* Adjust the value as needed */
                                                }

                                                select.form-control {
                                                    border-radius: 5px;
                                                    /* Adjust the value as needed */
                                                }
                                            </style>
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLongTitle" style="font-weight: bold;">Edit Control Measuring
                                                    Device</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>

                                            <form method="POST" action="{{ route('calibrations.update', ['calibration' => $cal->id]) }}"
                                                  enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                @if (session('error'))
                                                    <div class="alert alert-danger">
                                                        <strong>Error</strong><br>
                                                        <p>{{ session('error')['message'] }}</p>

                                                    </div>
                                                @endif

                                                <div id="section11" class="form-section">

                                                    <h5 style="font-weight: bold;font-size: 14px; padding-left: 30px; margin-bottom:0px; padding-top:10px; ">
                                                        HISTORY
                                                        DEVICE
                                                    </h5>
                                                    <div class="modal-body" style="display: flex; ">
                                                        <!-- Left Column -->
                                                        <div style="flex: 4; padding-right: 30px; padding-left: 30px;">

                                                            <div class="form-group" style="padding-right: 30px; padding-left: 40px; ">
                                                                <label for="con_after_cal" style="color: black">NIK:</label>
                                                                <input class="form-control form-control-sm" name="nik" type="text"
                                                                       value="{{ $user->nik }}" placeholder="input the shift.." required readonly>
                                                            </div>

                                                            <div class="form-group mb-3">
                                                                <label for="measuring_device_id" style="color: black">No Control</label>
                                                                <input type="text" class="form-control"
                                                                       value="{{ $measuring_device->where('id', $cal->measuring_device_id)->first()->no_control ?? '' }}">

                                                                <!-- Hidden input field to store the id value -->
                                                                <input type="hidden" id="measuring_device_id" name="measuring_device_id"
                                                                       value="{{ $cal->measuring_device_id }}">
                                                            </div>

                                                            <div class="form-group">

                                                                <label for="merk" style="color: black">Merk</label>
                                                                <input type="text" id="merk" class="form-control"
                                                                       value="{{ $measuring_device->where('id', $cal->measuring_device_id)->first()->merk->merk ?? '' }}"
                                                                       readonly>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="type" style="color: black">Type</label>
                                                                <input type="text" class="form-control type"
                                                                       placeholder="-- Choose No Control first --" readonly>
                                                            </div>
                                                            <h5 style="font-weight: bold;font-size: 14px; margin-left: -20px; margin-bottom:0px; padding-top:10px;">
                                                                Measuring
                                                                Device Condition</h5>
                                                            <div class="form-group">
                                                                <label for="con_before_cal" style="color: black">Before:</label>
                                                                <select class="form-control form-control-sm" name="con_before_cal" required>
                                                                    <option value="OK" {{ old('con_before_cal') == 'OK' ? 'selected' : '' }}>
                                                                        OK
                                                                    </option>
                                                                    <option value="N-OK" {{ old('con_before_cal') == 'N-OK' ? 'selected' : '' }}>
                                                                        N-Ok
                                                                    </option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group" style="">
                                                                <label for="con_after_cal" style="color: black">After:</label>
                                                                <select class="form-control form-control-sm" name="con_after_cal" required>
                                                                    <option value="OK" {{ old('con_after_cal') == 'OK' ? 'selected' : '' }}>
                                                                        OK
                                                                    </option>
                                                                    <option value="N-OK" {{ old('con_after_cal') == 'N-OK' ? 'selected' : '' }}>
                                                                        N-Ok
                                                                    </option>
                                                                </select>
                                                            </div>
                                                            <style>
                                                                .custom-file-input {
                                                                    cursor: pointer;

                                                                    position: absolute;
                                                                    width: 1px;
                                                                    height: 1px;
                                                                    overflow: hidden;
                                                                    clip: rect(0, 0, 0, 0);
                                                                    border: 0;
                                                                    padding: 0;

                                                                    .btn-success {
                                                                        background-color: #28a745 !important;
                                                                        /* Change to green color */
                                                                        border-color: #28a745 !important;
                                                                    }
                                                                }
                                                            </style>

                                                            <div class="form-group">
                                                                <label for="certificate" style="color: black">Certificate:</label>


                                                                <div class="input-group" style="margin-top:-10px; margin-bottom:-10px;">
                                                                    <input type="file" class="custom-file-input" id="file1" name="file1"
                                                                           style="display: none;" required onchange="updateFileName(this)">
                                                                    <div class="input-group-append" style="padding-right: 4px;">
                                                                        <button class="btn btn-secondary" id="file1Button"
                                                                                style="border-radius:4px;" type="button"
                                                                                onclick="document.getElementById('file1').click()">file1
                                                                        </button>
                                                                    </div>

                                                                    <input type="file" class="custom-file-input" id="file2" name="file2"
                                                                           style="display: none;" required onchange="updateFileName(this)">
                                                                    <div class="input-group-append">
                                                                        <button class="btn btn-secondary" style="border-radius:4px;"
                                                                                id="file2Button" type="button"
                                                                                onclick="document.getElementById('file2').click()">file2
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <script>
                                                                function updateFileButton(inputId, buttonId) {
                                                                    const button = document.getElementById(buttonId);
                                                                    const input = document.getElementById(inputId);
                                                                    input.addEventListener('change', function () {
                                                                        if (input.files.length > 0) {
                                                                            button.classList.add('btn-success');
                                                                        } else {
                                                                            button.classList.remove('btn-success');
                                                                        }
                                                                    });
                                                                }

                                                                updateFileButton('file2', 'file2Button');
                                                                updateFileButton('file1', 'file1Button');
                                                            </script>
                                                        </div>

                                                        <!-- Center Column -->
                                                        <div style="flex: 4; padding-right:30px;">
                                                            <div class="form-group" style="padding-right: 30px; padding-left: 30px;">
                                                                <label for="shift">Shift:</label>
                                                                <select class="form-control form-control-sm" name="shift">
                                                                    <option value="shift_1"
                                                                        {{ old('shift') == 'shift Pagi: 1' ? 'selected' : '' }}>
                                                                        Shift Pagi: 1
                                                                    </option>
                                                                    <option value="shift_2"
                                                                        {{ old('shift') == 'shift Malam: 2' ? 'selected' : '' }}>
                                                                        Shift Malam: 2
                                                                    </option>
                                                                </select>
                                                            </div>
                                                            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

                                                            <!-- Other input fields for device properties -->
                                                            <div class="form-group">
                                                                <label for="device_name">Device Name</label>
                                                                <input type="text" id="device_name" class="form-control"
                                                                       value="{{ $measuring_device->where('id', $cal->measuring_device_id)->first()->freq->device_name ?? '' }}"
                                                                       readonly>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="range">Range</label>
                                                                <input type="text" class="form-control range"
                                                                       placeholder="-- Choose No Control first --" readonly>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="resolution">Resolution</label>
                                                                <input type="text" class="form-control resolution"
                                                                       placeholder="-- Choose No Control first --" readonly>
                                                            </div>
                                                            <h5 style="font-size: 14px; margin-left: -10px; margin-bottom:0px; padding-top:10px;">
                                                                Calibration Result</h5>
                                                            <div class="form-group" style="">
                                                                <label for="result">Result:</label>
                                                                <select class="form-control form-control-sm" name="result" id="result"
                                                                        required>
                                                                    <option value="OK"
                                                                        {{ old('result', $cal->result) == 'OK' ? 'selected' : '' }}>
                                                                        OK
                                                                    </option>
                                                                    <option value="N-OK"
                                                                        {{ old('result', $cal->result) == 'N-OK' ? 'selected' : '' }}>
                                                                        N-OK
                                                                    </option>
                                                                </select>
                                                            </div>


                                                            <!-- Add an anchor tag with href pointing to section 2 -->
                                                            <div class="form-group">
                                                                <label for="no_certificate" style="color: black">No Certificate:</label>
                                                                <input class="form-control form-control-sm" name="no_certificate" type="text"
                                                                       value="{{ old('no_certificate') ?: $cal->no_certificate ?? '' }}"
                                                                       placeholder="Input the certificate number...">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="cal_supplier" style="color: black">Calibration Supplier:</label>
                                                                <input class="form-control form-control-sm" name="cal_supplier" type="text"
                                                                       value="{{ old('cal_supplier') ?: $cal->cal_supplier ?? '' }}"
                                                                       placeholder="Input the calibration supplier...">
                                                            </div>

                                                        </div>

                                                        <!-- Right Column -->
                                                        <div style="flex: 4; padding-right:20px">
                                                            <div class="form-group">
                                                                <label for="inv_no" style="color: black">Inv No</label>
                                                                <input type="text" class="form-control inv_no"
                                                                       placeholder="-- Choose No Control first --" readonly>
                                                            </div>
                                                            <div class="form-group" style="padding-bottom:6px;">
                                                                <label for="no_doc_bc" style="color: black">No Doc BC</label>
                                                                <input type="text" class="form-control no_doc_bc"
                                                                       placeholder="-- Choose No Control first --" readonly>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="ata_sai" style="color: black">ATA SAI</label>
                                                                <input type="text" class="form-control ata_sai"
                                                                       placeholder="-- Choose No Control first --" readonly>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="exp_date" style="color: black">Expiration Date</label>
                                                                <input type="date" class="form-control exp_date" readonly>
                                                            </div>

                                                            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                                                            <script>
                                                                $(document).ready(function () {
                                                                    function calculateExpirationDate() {
                                                                        var calDate = new Date($('.cal_date').val());
                                                                        var freqCalNum = parseInt($('.freq_cal_num').val());

                                                                        calDate.setMonth(calDate.getMonth() + freqCalNum);

                                                                        var expirationDate = calDate.toISOString().split('T')[0];

                                                                        $('.exp_date').val(expirationDate);
                                                                    }

                                                                    $('.cal_date').change(function () {
                                                                        calculateExpirationDate();
                                                                    });

                                                                    $('.freq_cal_num').change(function () {
                                                                        calculateExpirationDate();
                                                                    });
                                                                });
                                                            </script>
                                                            <div class="form-group">
                                                                <label for="cal_date" style="color: black">Calibration Date:</label>
                                                                <input class="form-control form-control-sm" name="cal_date" type="date"
                                                                       value="{{ old('cal_date') ?: $cal->cal_date ?? '' }}"
                                                                       placeholder="Input the calibration date ..">
                                                            </div>
                                                            <h5 style="font-weight: bold;font-size: 14px; margin-left: -5px; padding-top:0px;">
                                                                Device
                                                                Placement</h5>
                                                            <div class="form-group" style="padding-top:5px;">
                                                                <label for="area_id" style="color: black">Area:</label>
                                                                <select class="form-control form-control-sm" name="area_id">
                                                                    @foreach ($area as $areas)
                                                                        <option value="{{ $areas->id }}"
                                                                            {{ (isset($calibration) && $cal->area_id == $areas->id) || old('area_id') == $areas->id ? 'selected' : '' }}>
                                                                            {{ $areas->area }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="carname_id" style="color: black">Carname:</label>
                                                                <select class="form-control form-control-sm" name="carname_id">
                                                                    @foreach ($carname as $carnames)
                                                                        <option value="{{ $carnames->id }}"
                                                                            {{ (isset($calibration) && $cal->carname_id == $carnames->id) || old('carname_id') == $carnames->id ? 'selected' : '' }}>
                                                                            {{ $carnames->carname }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                        </div>
                                                    </div>


                                                </div>

                                                <div id="section22" class="form-section" style="display: none;">
                                                    <h5 style="font-weight:bold;font-size: 14px; padding-left: 30px; margin-bottom:0px; padding-top:10px;">
                                                        Service
                                                        Action
                                                    </h5>
                                                    <div class="modal-body" style="display: flex;">
                                                        <!-- Left Column -->
                                                        <div style="flex: 4; padding-right:30px; padding-left: 30px; ">

                                                            <div class="form-group">
                                                                <label for="start_ser_date" style="color: black">Start Date:</label>
                                                                <input class="form-control form-control-sm" name="start_ser_date" type="date"
                                                                       placeholder="Choose the start service date ..">
                                                            </div>
                                                            <hr>
                                                            <div class="form-group" style="margin-top:5px;">
                                                                <label for="no_control" style="color: black">No Control</label>
                                                                <input type="text" class="form-control no_control"
                                                                       placeholder="-- Choose No Control first --" readonly>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="merk" style="color: black">Merk</label>
                                                                <input type="text" class="form-control merk"
                                                                       placeholder="-- Choose No Control first --" readonly>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="type" style="color: black">Type</label>
                                                                <input type="text" class="form-control type"
                                                                       placeholder="-- Choose No Control first --" readonly>
                                                            </div>
                                                            <hr>

                                                            <div class="form-group">
                                                                <label for="life_time" style="color: black">Life time:</label>
                                                                <input class="form-control form-control-sm" name="life_time" type="date"
                                                                       placeholder="Input the calibration date ..">
                                                            </div>

                                                            <script>
                                                                $(document).ready(function () {
                                                                    function calculateLifeTime() {
                                                                        var calDate = new Date($('.cal_date').val());

                                                                        var freqCalNum = parseInt($('.freq_cal_num').val());

                                                                        calDate.setMonth(calDate.getMonth() + freqCalNum);

                                                                        var expirationDate = calDate.toISOString().split('T')[0];

                                                                        $('.exp_date').val(expirationDate);
                                                                    }

                                                                    $('.cal_date').change(function () {
                                                                        calculateLifeTime();
                                                                    });

                                                                    $('.freq_cal_num').change(function () {
                                                                        calculateLifeTime();
                                                                    });
                                                                });
                                                            </script>


                                                        </div>

                                                        <!-- Center Column -->
                                                        <div style="flex: 4; padding-right:30px;">
                                                            <div class="form-group">
                                                                <label for="finish_ser_date" style="color: black">Finish Date:</label>
                                                                <input class="form-control form-control-sm" name="finish_ser_date" type="date"
                                                                       placeholder="Choose the finish service date ..">
                                                            </div>
                                                            <hr>
                                                            <div class="form-group" style="padding-bottom:6px;">
                                                                <label for="device_name" style="color: black">Device Name</label>
                                                                <input type="text" class="form-control device_name"
                                                                       placeholder="-- Choose No Control first --" readonly>
                                                            </div>
                                                            <div class="form-group" style="margin-top:-5px;">
                                                                <label for="range" style="color: black">Range</label>
                                                                <input type="text" class="form-control range"
                                                                       placeholder="-- Choose No Control first --" readonly>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="resolution" style="color: black">Resolution</label>
                                                                <input type="text" class="form-control resolution"
                                                                       placeholder="-- Choose No Control first --" readonly>
                                                            </div>
                                                            <hr>
                                                            <div class="form-group">
                                                                <label for="next_action" style="color: black;">Next Action:</label>
                                                                <select class="form-control form-control-sm" name="next_action" required>
                                                                    <option value="" selected disabled>Select Next Action</option>
                                                                    <option value="Continue Calibration" style="color: green; font-weight: bold">
                                                                        Continue Calibration
                                                                    </option>
                                                                    <option value="Service" style="color: orange; font-weight: bold">Service
                                                                    </option>
                                                                    <option value="SCRAP" style="color: red; font-weight: bold">SCRAP</option>
                                                                </select>
                                                            </div>

                                                        </div>

                                                        <!-- Right Column -->
                                                        <div style="flex: 4; padding-right: 20px;">
                                                            <div class="form-group">
                                                                <label for="service_place" style="color: black;">Service Location</label>
                                                                <input type="text" class="form-control" name="service_place"
                                                                       placeholder="input service location...">
                                                            </div>
                                                            <hr>

                                                            <div class="form-group">
                                                                <label for="ata_sai" style="color: black;">ATA SAI</label>
                                                                <input type="text" class="form-control ata_sai"
                                                                       placeholder="-- Choose No Control first --" readonly>
                                                            </div>
                                                            <div class="form-group" style="padding-bottom:6px;">
                                                                <label for="inv_no" style="color: black;">Inv No</label>
                                                                <input type="text" class="form-control inv_no"
                                                                       placeholder="-- Choose No Control first --" readonly>
                                                            </div>
                                                            <div class="form-group" style="margin-top:-5px">
                                                                <label for="exp_date" style="color: black;">Exp Date</label>
                                                                <input type="date" class="form-control exp_date"
                                                                       placeholder="-- Choose No Control first --" readonly>
                                                            </div>
                                                            <hr>

                                                        </div>


                                                    </div>
                                                    <div class="form-group"
                                                         style="width: 100%; padding-left:50px; margin-bottom:20px; margin-top:-10px;">
                                                        <label for="problem" style="color: black;">Problem</label>
                                                        <textarea class="form-control" name="problem" rows="4"
                                                                  style="width: 60%; border: 1px solid #ced4da;border-radius:6px;"
                                                                  placeholder="Input problem..."></textarea>
                                                    </div>
                                                </div>

                                                <div class="modal-footer">
                                                    <button id="prevBtn2" type="button" class="btn btn-secondary"
                                                            style="background-color: black; font-weight: bold;">Back
                                                    </button>
                                                    <button id="nextBtn2" type="button" class="btn btn-primary"
                                                            style="font-weight: bold; background-color: #1378C6">Next
                                                    </button>
                                                    <button id="submitBtn2" type="submit" class="btn btn-primary"
                                                            style="background-color: #1378C6; font-weight: bold;">Submit
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                {{--                            modal edit end--}}
                                {{--                                modal delete--}}
                                <div class="modal fade" id="deleteCalibration{{ $cal->id }}" tabindex="-1" role="dialog"
                                     aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLongTitle">Delete
                                                    Calibration</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST"
                                                      action="{{ route('calibrations.destroy', $cal->id) }}"
                                                      enctype="multipart/form-data">
                                                    @csrf
                                                    @method('DELETE')
                                                    <div class="modal-body">Are you sure to delete this device with
                                                        number control
                                                        <br>
                                                        <b>{{ $cal->measuringDevice->no_control }}
                                                            - {{ $cal->measuringDevice->freq->device_name }}</b>?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Cancel
                                                        </button>
                                                        <button type="submit" class="btn btn-danger">Delete Device
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{--                            end delete--}}
                                {{--modal edit--}}

                                {{--                            modal edit end--}}
                                <!-- Modal untuk menampilkan file -->
                                <div class="modal fade" id="viewFileModal1{{ $cal->id }}" tabindex="-1" role="dialog"
                                     aria-labelledby="viewFileModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">View File 1</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <!-- Tempatkan konten file di sini -->
                                                <embed src="{{ asset('storage/' . $cal->file1) }}"
                                                       type="application/pdf" width="100%" height="600px"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal untuk menampilkan file -->
                                <div class="modal fade" id="viewFileModal2{{ $cal->id }}" tabindex="-1" role="dialog"
                                     aria-labelledby="viewFileModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">View File 2</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <!-- Tempatkan konten file di sini -->
                                                <embed src="{{ asset('storage/' . $cal->file2) }}"
                                                       type="application/pdf" width="100%" height="600px"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
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


    <!-- Script untuk memuat DataTables -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#cal').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "{{ route('cal_json.data') }}",
                "columns": [
                    {
                        "data": "id",
                        "name": "id"
                    },
                    {
                        "data": "shift",
                        "name": "shift",
                    },
                    {
                        "data": "measuring_device.no_control",
                        "name": "measuring_device.no_control"
                    },
                    {
                        "data": "measuring_device.freq.device_name",
                        "name": "measuringDevice.freq.device_name",
                    },
                    {
                        "data": "cal_date",
                        "name": "cal_date",
                        "render": function (data, type, row) {
                            // Parse tanggal dari string ke objek Date
                            var date = new Date(data);
                            // Ambil tanggal, bulan, dan tahun dari objek Date
                            var day = date.getDate();
                            var month = date.getMonth() + 1; // Ingat, bulan dimulai dari 0
                            var year = date.getFullYear();
                            // Format tanggal dengan menambahkan leading zero jika diperlukan
                            var formattedDate = (day < 10 ? '0' : '') + day + '-' + (month < 10 ? '0' : '') + month + '-' + year;
                            return formattedDate;
                        },
                    },
                    {
                        "data": "no_certificate",
                        "name": "no_certificate",
                        "render": function (data, type, row) {
                            if (data && data.no_certificate) {
                                return data.no_certificate;
                            } else {
                                return '-';
                            }
                        }
                    },
                    {
                        "data": "result",
                        "name": "result",
                        "render": function (data, type, row) {
                            if (data && data.result) {
                                return data.result;
                            } else {
                                return '-';
                            }

                        }
                    },
                    {
                        "data": "area.area",
                        "name": "area_id",
                    },
                    {
                        "data": "carname.carname",
                        "name": "carname_id",
                    },
                    {
                        "data": "expired_date",
                        "name": "expired_date",
                        "render": function (data, type, row) {
                            // Parse tanggal dari string ke objek Date
                            var date = new Date(data);
                            // Ambil tanggal, bulan, dan tahun dari objek Date
                            var day = date.getDate();
                            var month = date.getMonth() + 1; // Ingat, bulan dimulai dari 0
                            var year = date.getFullYear();
                            // Format tanggal dengan menambahkan leading zero jika diperlukan
                            var formattedDate = (day < 10 ? '0' : '') + day + '-' + (month < 10 ? '0' : '') + month + '-' + year;
                            return formattedDate;
                        },
                    },
                    {
                        "data": "nik",
                        "data": "nik",
                    },
                    {
                        "data": null,
                        "name": "actions",
                        "orderable": false,
                        "searchable": false,
                        "render": function (data, type, row) {
                            return '<button type="button" class="btn btn-success btn-icon btn-sm" data-toggle="modal" data-target="#editCalibration' + row.id + '"><i class="fas fa-pencil-alt"></i></button>'
                                +
                                '<button type="button" class="btn btn-danger btn-icon btn-sm deleteBtn" data-toggle="modal" data-target="#deleteCalibration' + row.id + '"><i class="fas fa-trash-alt"></i></button>'
                                +
                                '<button type="button" class="btn btn-warning btn-icon btn-sm view1Btn" data-toggle="modal" data-target="#viewFileModal1' + row.id + '"><i class="fas fa-eye"></i></button>'
                                +
                                '<button type="button" class="btn btn-warning btn-icon btn-sm view1Btn" data-toggle="modal" data-target="#viewFileModal2' + row.id + '"><i class="fas fa-eye"></i></button>'
                                ;

                        }
                    },
                ],
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                "order": [[0, 'asc']], // Default sorting by ID
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            // Function to handle change in result select
            $('select[name="result"]').change(function () {
                var result = $(this).val();
                var modalId = $(this).closest('.modal').attr('id'); // Get the ID of the current modal
                var nextBtn = $('#' + modalId +
                    ' #nextBtn2'); // Select the next button within the current modal
                var submitBtn = $('#' + modalId +
                    ' #submitBtn2'); // Select the submit button within the current modal
                var section22Inputs = $('#' + modalId + ' #section22 input, #' + modalId +
                    ' #section22 select, #' + modalId + ' #section22 textarea'
                ); // Select inputs within section22 of the current modal

                // Show or hide next button and submit button based on result
                if (result === 'N-OK') {
                    nextBtn.show();
                    submitBtn.hide();
                    section22Inputs.prop('required', true);
                } else {
                    nextBtn.hide();
                    submitBtn.show();
                    section22Inputs.prop('required', false);
                }
            });

            // Function to handle next button click
            $(document).on('click', '#nextBtn2', function (e) {
                e.preventDefault(); // Prevent the default behavior (closing the modal)
                var modalId = $(this).closest('.modal').attr('id'); // Get the ID of the current modal
                $('#' + modalId + ' #nextBtn2').hide();
                $('#' + modalId + ' #submitBtn2').show();
                $('#' + modalId + ' .form-section').hide();
                $('#' + modalId + ' #section22').show();
                $('#' + modalId + ' #prevBtn2').show();
                $('#' + modalId + ' #prevBtn2').removeAttr('data-dismiss'); // Remove data-dismiss attribute
            });

            // Function to handle back button click
            $(document).on('click', '#prevBtn2', function (e) {
                var modalId = $(this).closest('.modal').attr('id'); // Get the ID of the current modal
                if ($('#' + modalId + ' #section11').is(':visible')) {
                    // If currently on section 11, allow modal to close
                    $('#' + modalId + ' #prevBtn2').attr('data-dismiss', 'modal');
                } else {
                    e.stopPropagation(); // Prevent the click event from propagating

                    // If not on section 11, go back to section 11 without closing modal
                    $('#' + modalId + ' .form-section').hide();
                    $('#' + modalId + ' #section11').show();
                    $('#' + modalId + ' #nextBtn2').show();
                    $('#' + modalId + ' #submitBtn2').hide();
                    // Remove the data-dismiss attribute
                    $('#' + modalId + ' #prevBtn2').removeAttr('data-dismiss');
                }
            });

            // Function to handle submit button click
            $(document).on('click', '#submitBtn2', function () {
                console.log('Form submitted successfully!');
            });

            // Trigger change event to initialize form state
            $('select[name="result"]').trigger('change');
        });
    </script>

@endsection
