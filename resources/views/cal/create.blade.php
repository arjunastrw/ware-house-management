<div class="modal fade" id="createCalibration" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 1000px; -ms-flex-align: center;">
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
                <h5 class="modal-title font-weight-bold" id="exampleModalLongTitle">Control Measuring Device</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>



            <form method="POST" action="{{ route('calibrations.store') }}" enctype="multipart/form-data">
                @csrf
                <div id="section1" class="form-section">

                    <h5 style="font-size: 14px; padding-left: 30px; margin-bottom:0px; padding-top:10px; font-weight: bold">HISTORY DEVICE
                    </h5>
                    <div class="modal-body" style="display: flex; ">
                        <!-- Left Column -->
                        <div style="flex: 4; padding-right: 30px; padding-left: 30px;">

                            <div class="form-group" style="padding-right: 30px; padding-left: 40px; ">
                                <label for="con_after_cal" style="color: black">NIK:</label>
                                <input class="form-control form-control-sm" name="nik" type="text"
                                    value="{{ $user->nik }}" placeholder="input the shift.." required readonly style="color: black">
                            </div>
                            <div class="form-group mb-3">
                                <label for="measuring_device_id" style="color: black">No Control</label>
                                <select id="measuring_device_id" class="form-control" name="measuring_device_id">
                                    <option value="">-- Choose Process Controller --</option>
                                    <!-- Populate options dynamically from your data -->
                                    @foreach ($measuring_device as $noControl)
                                        <option value="{{ $noControl->id }}"
                                            data-no-control="{{ $noControl->no_control }}"
                                            data-device-name="{{ $noControl->freq->device_name }}"
                                            data-no-doc-bc="{{ $noControl->no_doc_bc }}"
                                            data-inv-no="{{ $noControl->inv_no }}"
                                            data-merk="{{ $noControl->merk->merk }}"
                                            data-range="{{ $noControl->range->range }}"
                                            data-ata-sai="{{ $noControl->ata_sai }}"
                                            data-type="{{ $noControl->type->type }}"
                                            data-resolution="{{ $noControl->resolution->resolution }}"
                                            data-exp-date="{{ $noControl->exp_date }}">
                                            {{ $noControl->no_control }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <script>
                                $(document).ready(function() {
                                    $('#measuring_device_id').on('change', function() {
                                        var selectedOption = $(this).find(':selected');
                                        var selectedDeviceName = selectedOption.data('device-name');
                                        var selectedNoDocBC = selectedOption.data('no-doc-bc');
                                        var selectedInvNo = selectedOption.data('inv-no');
                                        var selectedMerk = selectedOption.data('merk');
                                        var selectedRange = selectedOption.data('range');
                                        var selectedAtaSAI = selectedOption.data('ata-sai');
                                        var selectedType = selectedOption.data('type');
                                        var selectedResolution = selectedOption.data('resolution');
                                        var selectedExpDate = selectedOption.data('exp-date');
                                        var selectedNoControl = selectedOption.data('no-control');

                                        // Set the selected Device Name and No Doc BC to the text inputs
                                        $('.device_name').val(selectedDeviceName);
                                        $('.no_doc_bc').val(selectedNoDocBC);
                                        $('.inv_no').val(selectedInvNo);
                                        $('.merk').val(selectedMerk);
                                        $('.range').val(selectedRange);
                                        $('.ata_sai').val(selectedAtaSAI);
                                        $('.type').val(selectedType);
                                        $('.resolution').val(selectedResolution);
                                        $('.exp_date').val(selectedExpDate);
                                        $('.no_control').val(selectedNoControl);

                                    });

                                    // Initial setup
                                    $('#measuring_device_id').change();
                                });
                            </script>
                            <div class="form-group">
                                <label for="merk" style="color: black">Merk</label>
                                <input type="text" class="form-control merk"
                                    placeholder="-- Choose No Control first --" readonly style="color: black;">
                            </div>
                            <div class="form-group">
                                <label for="type" style="color: black">Type</label>
                                <input type="text" class="form-control type"
                                    placeholder="-- Choose No Control first --" readonly>
                            </div>
                            <h5 style="font-size: 14px; margin-left: -20px; margin-bottom:0px; padding-top:10px; color: black;">
                                Measuring
                                Device Condition</h5>
                            <div class="form-group" style="">
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
                                        <button class="btn btn-secondary" id="file1Button" style="border-radius:4px;" type="button"
                                            onclick="document.getElementById('file1').click()">file1</button>
                                    </div>

                                    <input type="file" class="custom-file-input"  id="file2" name="file2"
                                        style="display: none;" required onchange="updateFileName(this)">
                                    <div class="input-group-append">
                                        <button class="btn btn-secondary" style="border-radius:4px;" id="file2Button" type="button"
                                            onclick="document.getElementById('file2').click()">file2</button>
                                    </div>
                                </div>
                            </div>
                            <script>
                                function updateFileButton(inputId, buttonId) {
                                    const button = document.getElementById(buttonId);
                                    const input = document.getElementById(inputId);
                                    input.addEventListener('change', function() {
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
                                <label for="shift" style="color: black">Shift:</label>
                                <select class="form-control form-control-sm" name="shift">
                                    <option value="shift_1" {{ old('shift') == 'shift Pagi: 1' ? 'selected' : '' }}>
                                        Shift Pagi: 1
                                    </option>
                                    <option value="shift_2" {{ old('shift') == 'shift Malam: 2' ? 'selected' : '' }}>
                                        Shift Malam: 2
                                    </option>
                                </select>
                            </div>
                            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

                            <div class="form-group" style="padding-bottom:6px;">
                                <label for="device_name" style="color: black">Device Name</label>
                                <input type="text" class="form-control device_name"
                                    placeholder="-- Choose No Control first --" readonly>
                            </div>
                            <div class="form-group">
                                <label for="range" style="color: black">Range</label>
                                <input type="text" class="form-control range"
                                    placeholder="-- Choose No Control first --" readonly>
                            </div>
                            <div class="form-group">
                                <label for="resolution" style="color: black">Resolution</label>
                                <input type="text" class="form-control resolution"
                                    placeholder="-- Choose No Control first --" readonly>
                            </div>
                            <h5 style="font-size: 14px; margin-left: -10px; margin-bottom:0px; padding-top:10px;">
                                Calibration Result</h5>
                            <div class="form-group" style="">
                                <label for="result" style="color: black">Result:</label>
                                <select class="form-control form-control-sm" name="result" required>
                                    <option value="">-- Choose Calibration Result --</option>
                                    <option value="OK" {{ old('result') == 'OK' ? 'selected' : '' }}>
                                        OK
                                    </option>
                                    <option value="N-OK" {{ old('result') == 'N-OK' ? 'selected' : '' }}>
                                        N-Ok
                                    </option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="no_certificate" style="color: black">No Certificate:</label>
                                <input class="form-control form-control-sm" name="no_certificate" type="text"
                                    placeholder="input the certificate number..." required>
                            </div>
                            <div class="form-group">
                                <label for="cal_supplier" style="color: black">Calibration Supplier:</label>
                                <input class="form-control form-control-sm" name="cal_supplier" type="text"
                                    placeholder="input the calibration supplier..." required>
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
                                <label for="exp_date" style="color: black">Exp Date</label>
                                <input type="date" class="form-control exp_date"
                                    placeholder="-- Choose No Control first --">
                            </div>
                            <div class="form-group">
                                <label for="cal_date" style="color: black">Calibration Date:</label>
                                <input class="form-control form-control-sm" name="cal_date" type="date"
                                    placeholder="Input the calibration date .." required>
                            </div>
                            <h5 style="font-size: 14px; margin-left: -5px; padding-top:0px;" style="color: black">Device
                                Placement</h5>
                                <div class="form-group" style="padding-top:5px;">
                                    <label for="area_id" style="color: black">Area:</label>
                                    <select class="form-control form-control-sm" name="area_id" required>
                                        <option value="">Select Area</option>
                                        @foreach ($area as $area)
                                            <option value="{{ $area->id }}"
                                                {{ old('area_id') == $area->id ? 'selected' : '' }}>
                                                {{ $area->area }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="carname_id" style="color: black">Carname:</label>
                                    <select class="form-control form-control-sm" name="carname_id" required>
                                        <option value="">Select Carname</option>
                                        @foreach ($carname as $carname)
                                            <option value="{{ $carname->id }}"
                                                {{ old('carname') == $carname->id ? 'selected' : '' }}>
                                                {{ $carname->carname }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                        </div>
                    </div>


                </div>

                <div id="section2" class="form-section" style="display: none;">
                    <h5 class="font-weight-bold" style="font-size: 14px; padding-left: 30px; margin-bottom:0px; padding-top:10px;">Service
                        Action
                    </h5>
                    <div class="modal-body" style="display: flex;">
                        <!-- Left Column -->
                        <div style="flex: 4; padding-right:30px; padding-left: 30px; ">

                            <div class="form-group">
                                <label for="start_ser_date" style="color: black;">Start Date:</label>
                                <input class="form-control form-control-sm" name="start_ser_date" type="date"
                                    placeholder="Choose the start service date .." required>
                            </div>
                            <hr>
                            <div class="form-group" style="margin-top:5px;">
                                <label for="no_control" style="color: black;">No Control</label>
                                <input type="text" class="form-control no_control"
                                    placeholder="-- Choose No Control first --" readonly>
                            </div>
                            <div class="form-group">
                                <label for="merk" style="color: black;">Merk</label>
                                <input type="text" class="form-control merk"
                                    placeholder="-- Choose No Control first --" readonly>
                            </div>
                            <div class="form-group">
                                <label for="type" style="color: black;">Type</label>
                                <input type="text" class="form-control type"
                                    placeholder="-- Choose No Control first --" readonly>
                            </div>
                            <hr>

                            <div class="form-group">
                                <label for="life_time" style="color: black;">Life time:</label>
                                <input class="form-control form-control-sm" name="life_time" type="date"
                                    placeholder="Input the calibration date .." required>
                            </div>


                        </div>

                        <!-- Center Column -->
                        <div style="flex: 4; padding-right:30px;">
                            <div class="form-group">
                                <label for="finish_ser_date" style="color: black;">Finish Date:</label>
                                <input class="form-control form-control-sm" name="finish_ser_date" type="date"
                                    placeholder="Choose the finish service date .." required>
                            </div>
                            <hr>
                            <div class="form-group" style="padding-bottom:6px;">
                                <label for="device_name" style="color: black;">Device Name</label>
                                <input type="text" class="form-control device_name"
                                    placeholder="-- Choose No Control first --" readonly>
                            </div>
                            <div class="form-group" style="margin-top:-5px;">
                                <label for="range" style="color: black;">Range</label>
                                <input type="text" class="form-control range"
                                    placeholder="-- Choose No Control first --" readonly>
                            </div>
                            <div class="form-group">
                                <label for="resolution" style="color: black;">Resolution</label>
                                <input type="text" class="form-control resolution"
                                    placeholder="-- Choose No Control first --" readonly>
                            </div>
                            <hr>
                            <div class="form-group">
                                <label for="next_action" style="color: black;">Next Action:</label>
                                <select class="form-control form-control-sm" name="next_action" required>
                                    <option value="" selected disabled>Select Next Action</option>
                                    <option value="Continue Calibration" style="color: green; font-weight: bold">Continue Calibration</option>
                                    <option value="Service" style="color: orange; font-weight: bold">Service</option>
                                    <option value="SCRAP" style="color: red; font-weight: bold">SCRAP</option>
                                </select>
                            </div>

                        </div>

                        <!-- Right Column -->
                        <div style="flex: 4; padding-right: 20px;">
                            <div class="form-group">
                                <label for="service_place">Service Location</label>
                                <input type="text" class="form-control" name="service_place"
                                    placeholder="input service location..." required>
                            </div>
                            <hr>

                            <div class="form-group">
                                <label for="ata_sai">ATA SAI</label>
                                <input type="text" class="form-control ata_sai"
                                    placeholder="-- Choose No Control first --" readonly>
                            </div>
                            <div class="form-group" style="padding-bottom:6px;">
                                <label for="inv_no">Inv No</label>
                                <input type="text" class="form-control inv_no"
                                    placeholder="-- Choose No Control first --" readonly>
                            </div>
                            <div class="form-group" style="margin-top: -5px;">
                                <label for="exp_date">Exp Date</label>
                                <input type="date" class="form-control exp_date" name="expired_date" placeholder="-- Choose No Control first --" readonly>
                            </div>

                            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                            <script>
                                $(document).ready(function() {
                                    $('.cal_date').change(function() {
                                        var calDate = $(this).val();
                                        if (calDate) {
                                            // Lakukan permintaan AJAX untuk mendapatkan freq_cal_num dari server
                                            $.ajax({
                                                url: '/get-freq-cal-num', // Ganti dengan URL yang sesuai
                                                type: 'GET',
                                                dataType: 'json',
                                                success: function(response) {
                                                    if (response.success) {
                                                        var freqCalNum = response.freqCalNum;
                                                        if (freqCalNum) {
                                                            // Hitung expired_date
                                                            var calDateObj = new Date(calDate);
                                                            calDateObj.setDate(calDateObj.getDate() + freqCalNum);
                                                            var expDate = calDateObj.toISOString().split('T')[0];
                                                            // Atur nilai expired_date pada input
                                                            $('.exp_date').val(expDate);
                                                        } else {
                                                            $('.exp_date').val('-- No Frequency Calibration Number --');
                                                        }
                                                    } else {
                                                        $('.exp_date').val('-- Error fetching frequency calibration number --');
                                                    }
                                                },
                                                error: function() {
                                                    $('.exp_date').val('-- Error fetching frequency calibration number --');
                                                }
                                            });
                                        } else {
                                            $('.exp_date').val('-- Choose Calibration Date first --');
                                        }
                                    });
                                });
                            </script>
                            <hr>


                            {{-- <div class="form-group" style="padding-top:5px;">
                                    <label for="area_id">Area:</label>
                                    <select class="form-control form-control-sm" name="area_id" required>
                                        <option value="">Select Area</option>
                                        @foreach ($area as $area)
                                            <option value="{{ $area->id }}"
                                                {{ old('area_id') == $area->id ? 'selected' : '' }}>
                                                {{ $area->area }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="carname_id">Carname:</label>
                                    <select class="form-control form-control-sm" name="carname_id" required>
                                        <option value="">Select Carname</option>
                                        @foreach ($carname as $carname)
                                            <option value="{{ $carname->id }}"
                                                {{ old('carname') == $carname->id ? 'selected' : '' }}>
                                                {{ $carname->carname }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div> --}}

                        </div>
                    </div>
                    <div class="form-group"
                        style="width: 100%; padding-left:50px; margin-bottom:20px; margin-top:-10px;">
                        <label for="problem" style="color: black;">Problem</label>
                        <textarea class="form-control" name="problem" rows="4"
                            style="width: 60%; border: 1px solid #ced4da;border-radius:6px;" placeholder="Input problem..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="prevBtn" type="button" class="btn btn-secondary" style="background-color: black
                    ; font-weight: bold;">Back</button>
                    <button id="nextBtn" type="button" class="btn btn-primary" style="background-color: #1378c6; font-weight: bold;">Next</button>
                    <button id="submitBtn" type="submit" class="btn btn-primary"
                        style="display: none; background-color: #1378c6; font-weight: bold;">Submit</button>
                </div>
            </form>

        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('select[name="result"]').change(function() {
            var result = $(this).val();
            if (result === 'N-OK') {
                $('#nextBtn').show();
                $('#submitBtn').hide();
                $('#section2 input').prop('required', true);
                $('#section2 select').prop('required', true);
                $('#section2 textarea').prop('required', true);
            } else {
                $('#nextBtn').hide();
                $('#submitBtn').show();
                $('#section2 input').prop('required', false);
                $('#section2 select').prop('required', false);
                $('#section2 textarea').prop('required', false);

            }
        });

        $('#nextBtn').click(function() {
            $('#nextBtn').hide();
            $('#submitBtn').show();
            $('.form-section').hide();
            $('#section2').show();
            $('#prevBtn').show();
        });

        $('#prevBtn').click(function() {
            if ($('#section1').is(':visible')) {
                $('#prevBtn').attr('data-dismiss', 'modal');
            } else {
                $('.form-section').hide();
                $('#section1').show();
                $('#nextBtn').show();
                $('#submitBtn').hide();
                $('#prevBtn').removeAttr('data-dismiss');
            }
        });

        $('#submitBtn').click(function() {
            // Here you can submit the form using AJAX or perform other actions
            // For demonstration, we'll just log a message
            console.log('Form submitted successfully!');
        });

        $('select[name="result"]').trigger('change');
    });
</script>
