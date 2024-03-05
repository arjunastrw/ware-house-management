    <div class="modal fade" id="editFreq{{ $value->id }}" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold" id="exampleModalLongTitle">Edit Frequency Device</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('freq.update', $value->id) }}">
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
                                <label for="device_name" style="color: black; font-weight: bold">Device Name:</label>
                                <input class="form-control form-control-sm" name="device_name" type="text"
                                    placeholder="input the no control.." value="{{ $value->device_name }}" required style="color: black; font-weight: bold;">
                            </div>
                            <div class="form-group">
                                <label for="cal_status" style="color: black; font-weight: bold">Status</label>
                                <select class="form-control form-control-sm" name="cal_status" required>
                                    <option value="Internal" @if(old('cal_status') == 'Internal') selected @endif>Internal</option>
                                    <option value="External" @if(old('cal_status') == 'External') selected @endif>External</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="freq_cal_num" style="color: black; font-weight: bold">Frequency Number:</label>
                                <input class="form-control form-control-sm" name="freq_cal_num" type="text"
                                    placeholder="input the no control.." value="{{ $value->freq_cal_num }}" required>
                            </div>
                            <div class="form-group">
                                <label for="freq_cal_unit" style="color: black; font-weight: bold">Choose Unit</label>
                                <select class="form-control form-control-sm" name="freq_cal_unit" required>
                                    <option value="year" @if (old('freq_cal_unit') == 'year') selected @endif>Year
                                    </option>
                                    <option value="month" @if (old('freq_cal_unit') == 'month') selected @endif>Month
                                    </option>
                                    <option value="time (first came)" @if (old('freq_cal_unit') == 'time (first came)') selected @endif>time (first came)
                                    </option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="life_time_num" style="color: black; font-weight: bold">Life Time Number:</label>
                                <input class="form-control form-control-sm" name="life_time_num" type="text"
                                    placeholder="input the no control.." value="{{ $value->life_time_num }}" required>
                            </div>
                            <div class="form-group">
                                <label for="life_time_unit" style="color: black; font-weight: bold">Choose Life Time Unit</label>
                                <select class="form-control form-control-sm" name="life_time_unit" required>
                                    <option value="year" @if (old('life_time_unit') == 'year') selected @endif>Year
                                    </option>
                                    <option value="month" @if (old('life_time_unit') == 'month') selected @endif>Month
                                    </option>
                                    <option value="time (first came)" @if (old('life_time_unit') == 'time (first came)') selected @endif>time (first came)
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" style="font-weight: bold; background-color: black; font-weight: bold">Cancel</button>
                            <button type="submit" class="btn btn-primary" style="font-weight: bold; background-color: #1A7FCC; font-weight: bold">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
