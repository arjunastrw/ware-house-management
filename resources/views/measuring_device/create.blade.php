<div class="modal fade" id="createMeasuringDevice" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle" style="font-weight: bold">Add Measuring Device</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

            </div>

            <div class="modal-body">
                <form method="POST" action="{{ route('measuring_devices.store') }}">
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
                            <label for="no_control" style="color: black; font-weight: normal">No Control:</label>
                            <input class="form-control form-control-sm" name="no_control" type="text" value="{{ old('no_control') }}" placeholder="input the control number.." required>
                        </div>
                        <div class="form-group">
                            <label for="freq_cal_measuring_device_id" style="color: black; font-weight: normal">Device Name:</label>
                            <select class="form-control form-control-sm" name="freq_cal_measuring_device_id" required>
                                <option value="">Select Device</option>
                                @foreach($freqs as $device)
                                <option value="{{ $device->id }}" {{ old('freq_cal_measuring_device_id') == $device->id ? 'selected' : '' }}>
                                    {{ $device->device_name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="type_id" style="color: black; font-weight: normal">Type:</label>
                            <select class="form-control form-control-sm" name="type_id" required>
                                <option value="">Select Type</option>
                                @foreach($types as $type)
                                <option value="{{ $type->id }}" {{ old('type_id') == $type->id ? 'selected' : '' }}>
                                    {{ $type->type }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="merk_id" style="color: black; font-weight: normal">Merk:</label>
                            <select class="form-control form-control-sm" name="merk_id" required>
                                <option value="">Select Merk</option>
                                @foreach($merks as $merk)
                                <option value="{{ $merk->id }}" {{ old('merk_id') == $merk->id ? 'selected' : '' }}>
                                    {{ $merk->merk }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="no_seri" style="color: black; font-weight: normal">No Seri:</label>
                            <input class="form-control form-control-sm" name="no_seri" type="text" placeholder="input the seri number .." required>
                        </div>
                        <div class="form-group">
                            <label for="range_id" style="color: black; font-weight: normal">Range:</label>
                            <select class="form-control form-control-sm" name="range_id" required>
                                <option value="">Select Range</option>
                                @foreach($ranges as $range)
                                <option value="{{ $range->id }}" {{ old('range_id') == $range->id ? 'selected' : '' }}>
                                    {{ $range->range }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="resolution_id" style="color: black; font-weight: normal">Resolution:</label>
                            <select class="form-control form-control-sm" name="resolution_id" required>
                                <option value="">Select Resolution</option>
                                @foreach($resolutions as $resolution)
                                <option value="{{ $resolution->id }}" {{ old('resolution_id') == $resolution->id ? 'selected' : '' }}>
                                    {{ $resolution->resolution }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="ata_sai" style="color: black; font-weight: normal">ATA SAI:</label>
                            <input class="form-control form-control-sm" name="ata_sai" type="date" placeholder="input the ata_sai .." required>
                        </div>
                        <div class="form-group">
                            <label for="inv_no" style="color: black; font-weight: normal">Inv No:</label>
                            <input class="form-control form-control-sm" name="inv_no" type="text" placeholder="input the inv no .." required>
                        </div>
                        <div class="form-group">
                            <label for="no_doc_bc" style="color: black; font-weight: normal">No Doc BC:</label>
                            <input class="form-control form-control-sm" name="no_doc_bc" type="text" placeholder="Input the no doc bc .." required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="level" value="admin">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" style="background-color: black; font-weight: bold">Back</button>
                        <button type="submit" class="btn btn-primary" style="background-color: #268bd9; font-weight: bold">Add Measuring Devices</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
