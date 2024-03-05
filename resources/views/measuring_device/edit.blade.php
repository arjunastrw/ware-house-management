@foreach( $measuring_device as $key => $value)
<div class="modal fade" id="editMeasuringDevice{{ $value->id }}" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold" id="exampleModalLongTitle">Edit Calibration</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('measuring_devices.update', ['measuring_device' => $value->id]) }}">
                        @csrf
                        @method('PUT')
                        @if (session('error'))
                            <div class="alert alert-danger">
                                <strong>Error</strong><br>
                                <p>{{ session('error')['message'] }}</p>

                            </div>
                        @endif
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="no_control" style="color: black">No Control:</label>
                                <input class="form-control form-control-sm" name="no_control" type="text"
                                    placeholder="input the no control.." value="{{ $value->no_control }}"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="freq_cal_measuring_device_id" style="color: black">Device Name:</label>
                                <select class="form-control form-control-sm" name="freq_cal_measuring_device_id"
                                    required>
                                    <option value="">Select Device</option>
                                    @foreach ($freqs as $freq)
                                        <option value="{{ $freq->id }}"
                                            {{ old('freq_cal_measuring_device_id', $value->freq_cal_measuring_device_id) == $freq->id ? 'selected' : '' }}>
                                            {{ $freq->device_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="type_id" style="color: black">Type:</label>
                                <select class="form-control form-control-sm" name="type_id" required>
                                    <option value="">Select Type</option>
                                    @foreach ($types as $type)
                                        <option value="{{ $type->id }}"
                                            {{ old('type_id', $value->type_id) == $type->id ? 'selected' : '' }}>
                                            {{ $type->type }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="merk_id" style="color: black">Merk:</label>
                                <select class="form-control form-control-sm" name="merk_id" required>
                                    <option value="">Select Merk</option>
                                    @foreach ($merks as $merk)
                                        <option value="{{ $merk->id }}"
                                            {{ old('merk_id', $value->merk_id) == $merk->id ? 'selected' : '' }}>
                                            {{ $merk->merk }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="no_seri" style="color: black">No Seri:</label>
                                <input class="form-control form-control-sm" name="no_seri" type="text"
                                    placeholder="input the no seri.." value="{{ $value->no_seri }}"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="range_id" style="color: black">Range:</label>
                                <select class="form-control form-control-sm" name="range_id" required>
                                    <option value="">Select Range</option>
                                    @foreach ($ranges as $range)
                                        <option value="{{ $range->id }}"
                                            {{ old('range_id', $value->range_id) == $range->id ? 'selected' : '' }}>
                                            {{ $range->range }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="resolution_id" style="color: black">Resolution:</label>
                                <select class="form-control form-control-sm" name="resolution_id" required>
                                    <option value="">Select Resolution</option>
                                    @foreach ($resolutions as $resolution)
                                        <option value="{{ $resolution->id }}"
                                            {{ old('resolution_id', $value->resolution_id) == $resolution->id ? 'selected' : '' }}>
                                            {{ $resolution->resolution }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="ata_sai" style="color: black">ATA SAI:</label>
                                <input class="form-control form-control-sm" name="ata_sai" type="date"
                                    placeholder="input the ATA SAI.." value="{{ $value->ata_sai }}"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="inv_no" style="color: black">Invoice No:</label>
                                <input class="form-control form-control-sm" name="inv_no" type="text"
                                    placeholder="input the Invoice No.." value="{{ $value->inv_no }}"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="no_doc_bc" style="color: black">No Doc Bc::</label>
                                <input class="form-control form-control-sm" name="no_doc_bc" type="text"
                                    placeholder="input the No Doc Bc.." value="{{ $value->no_doc_bc }}"
                                    required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" style="background-color: black; font-weight: bold; margin-right: 10px;">Cancel</button>
                            <button type="submit" class="btn btn-primary" style="background-color: #298edc; font-weight: bold;">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach
