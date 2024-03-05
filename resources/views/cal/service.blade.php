<div class="modal fade" id="serviceCalibration" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
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
                <h5 class="modal-title" id="exampleModalLongTitle">Control Measuring Device</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <h5 style="font-size: 14px; padding-left: 30px; margin-bottom:0px; padding-top:10px;">HISTORY DEVICE</h5>


            <form method="POST" action="{{ route('calibrations.store') }}">
                @csrf
                <div class="modal-body" style="display: flex;">
                    <!-- Left Column -->
                    <div style="flex: 4; padding-right: 30px; padding-left: 30px;">

                        <div class="form-group" style="padding-right: 30px; padding-left: 40px; ">
                            <label for="con_after_cal">NIK:</label>
                            <input class="form-control form-control-sm" name="nik" type="text"
                                value="{{ $user->nik }}" placeholder="input the shift.." required readonly>
                        </div>
                        <div class="form-group mb-3">
                            <label for="measuring_device_id">No Control</label>
                            <select id="measuring_device_id" class="form-control" name="measuring_device_id">
                                <option value="">-- Choose Process Controller --</option>
                                <!-- Populate options dynamically from your data -->
                                @foreach ($measuring_device as $noControl)
                                    <option value="{{ $noControl->id }}"
                                        data-device-name="{{ $noControl->freq->device_name }}"
                                        data-no-doc-bc="{{ $noControl->no_doc_bc }}"
                                        data-inv-no="{{ $noControl->inv_no }}" data-merk="{{ $noControl->merk->merk }}"
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

                                });

                                // Initial setup
                                $('#measuring_device_id').change();
                            });
                        </script>
                        <div class="form-group">
                            <label for="merk">Merk</label>
                            <input type="text" class="form-control merk" placeholder="-- Choose No Control first --"
                                readonly>
                        </div>
                        <div class="form-group">
                            <label for="type">Type</label>
                            <input type="text" class="form-control type" placeholder="-- Choose No Control first --"
                                readonly>
                        </div>
                        <h5 style="font-size: 14px; margin-left: -20px; margin-bottom:0px; padding-top:10px;">Measuring
                            Device Condition</h5>
                        <div class="form-group" style="">
                            <label for="con_before_cal">Before:</label>
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
                            <label for="con_after_cal">After:</label>
                            <select class="form-control form-control-sm" name="con_after_cal" required>
                                <option value="OK" {{ old('con_after_cal') == 'OK' ? 'selected' : '' }}>
                                    OK
                                </option>
                                <option value="N-OK" {{ old('con_after_cal') == 'N-OK' ? 'selected' : '' }}>
                                    N-Ok
                                </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="certificate">Sertificate:</label>
                            <input class="form-control form-control-sm" name="certificate" type="text"
                                placeholder="input the certificate number..." required>
                        </div>
                    </div>

                    <!-- Center Column -->
                    <div style="flex: 4; padding-right:30px;">
                        <div class="form-group" style="padding-right: 30px; padding-left: 30px;">
                            <label for="shift">Shift:</label>
                            <select class="form-control form-control-sm" name="shift" required>
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
                            <label for="device_name">Device Name</label>
                            <input type="text" class="form-control device_name"
                                placeholder="-- Choose No Control first --" readonly>
                        </div>
                        <div class="form-group">
                            <label for="range">Range</label>
                            <input type="text" class="form-control range" placeholder="-- Choose No Control first --"
                                readonly>
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
                            <select class="form-control form-control-sm" name="result" required>
                                <option value="OK" {{ old('result') == 'OK' ? 'selected' : '' }}>
                                    OK
                                </option>
                                <option value="N-OK" {{ old('result') == 'N-OK' ? 'selected' : '' }}>
                                    N-Ok
                                </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="no_certificate">No Certificate:</label>
                            <input class="form-control form-control-sm" name="no_certificate" type="text"
                                placeholder="input the certificate number..." required>
                        </div>
                        <div class="form-group">
                            <label for="cal_supplier">Calibration Supplier:</label>
                            <input class="form-control form-control-sm" name="cal_supplier" type="text"
                                placeholder="input the calibration supplier..." required>
                        </div>
                        
                    </div>

                    <!-- Right Column -->
                    <div style="flex: 4;">
                        <div class="form-group">
                            <label for="inv_no">Inv No</label>
                            <input type="text" class="form-control inv_no"
                                placeholder="-- Choose No Control first --" readonly>
                        </div>
                        <div class="form-group" style="padding-bottom:6px;">
                            <label for="no_doc_bc">No Doc BC</label>
                            <input type="text" class="form-control no_doc_bc"
                                placeholder="-- Choose No Control first --" readonly>
                        </div>
                        <div class="form-group">
                            <label for="ata_sai">ATA SAI</label>
                            <input type="text" class="form-control ata_sai"
                                placeholder="-- Choose No Control first --" readonly>
                        </div>
                        <div class="form-group">
                            <label for="exp_date">Exp Date</label>
                            <input type="date" class="form-control exp_date"
                                placeholder="-- Choose No Control first --" readonly>
                        </div>
                        <div class="form-group">
                            <label for="cal_date">Calibration Date:</label>
                            <input class="form-control form-control-sm" name="cal_date" type="date"
                                placeholder="Input the calibration date .." required>
                        </div>
                        <h5 style="font-size: 14px; margin-left: -5px; padding-top:0px;">Device
                            Placement
                            <div class="form-group" style="padding-top:5px;">
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
                            </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Back</button>
                    <button type="submit" class="btn btn-primary">Add Measuring DeviceS</button>
                </div>
            </form>

        </div>
    </div>
</div>
