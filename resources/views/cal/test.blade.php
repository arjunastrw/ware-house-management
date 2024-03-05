<div class="modal fade" id="createCalibration" tabindex="-1" role="dialog" aria-labelledby=""
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Add Calibration</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

            </div>

            <div class="modal-body" >
                <form method="POST" action="{{ route('calibrations.store') }}">
                    @csrf
                    {{-- @if (isset(session('error')['old_input']))
                        <!-- Access old input values -->
                        {{ session('error')['old_input']['no_control'] }}
                        {{ session('error')['old_input']['device_name'] }}
                        <!-- Add more fields as needed -->
                    @endif --}}

                    @if (session('error'))
                        <div class="alert alert-danger">
                            <strong>Error</strong><br><br>
                            <p>{{ session('error')['message'] }}</p>
                            
                        </div>
                    @endif
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nik">nik:</label>
                            <input class="form-control form-control-sm" name="nik" type="text"
                                value="{{ old('nik') }}" placeholder="input the shift.." required>
                        </div>
                        <div class="form-group">
                            <label for="shift">Shift:</label>
                            <input class="form-control form-control-sm" name="shift" type="text"
                                value="{{ old('shift') }}" placeholder="input the shift.." required>
                        </div>
                        <div class="form-group">
                            <label for="measuring_device_id">No Control:</label>
                            <select class="form-control form-control-sm" name="measuring_device_id" required>
                                <option value=""> Choose No Control</option>
                                @foreach($measuring_device as $device)
                                    <option value="{{ $device->id }}" {{ old('measuring_device_id') == $device->id ? 'selected' : '' }}>
                                        {{ $device->no_control }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="area_id">Area:</label>
                            <select class="form-control form-control-sm" name="area_id" required>
                                <option value="">Select Area</option>
                                @foreach($area as $area)
                                    <option value="{{ $area->id }}" {{ old('area_id') == $area->id ? 'selected' : '' }}>
                                        {{ $area->area }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="carname_id">Carname:</label>
                            <select class="form-control form-control-sm" name="carname_id" required>
                                <option value="">Select Carname</option>
                                @foreach($carname as $carname)
                                    <option value="{{ $carname->id }}" {{ old('carname') == $carname->id ? 'selected' : '' }}>
                                        {{ $carname->carname }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="con_after_cal">After:</label>
                            <input class="form-control form-control-sm" name="con_after_cal" type="text"
                                placeholder="input the seri number .." required>
                        </div>
                        <div class="form-group">
                            <label for="con_before_cal">Before:</label>
                            <input class="form-control form-control-sm" name="con_before_cal" type="text"
                                placeholder="input the ata_sai .." required>
                        </div>
                        <div class="form-group">
                            <label for="no_certificate">No Certificate:</label>
                            <input class="form-control form-control-sm" name="no_certificate" type="text"
                                placeholder="input the inv no .." required>
                        </div>
                        <div class="form-group">
                            <label for="certificate">Certificate:</label>
                            <input class="form-control form-control-sm" name="certificate" type="text"
                                placeholder="Input the no doc bc .." required>
                        </div>
                        <div class="form-group">
                            <label for="result">result:</label>
                            <input class="form-control form-control-sm" name="result" type="text"
                                placeholder="Input the no doc bc .." required>
                        </div>
                        <div class="form-group">
                            <label for="cal_date">Calibration Date:</label>
                            <input class="form-control form-control-sm" name="cal_date" type="date"
                                placeholder="Input the no doc bc .." required>
                        </div>
                        <div class="form-group">
                            <label for="cal_supplier">Calibration Supplier:</label>
                            <input class="form-control form-control-sm" name="cal_supplier" type="text"
                                placeholder="Input the no doc bc .." required>
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
</div>
