<div class="modal fade" id="createFreq" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Add Frequency</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

            </div>

            <div class="modal-body" >
                <form method="POST" action="{{ route('freq.store') }}">
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
                            <label for="device_name" class="font-weight-bold">Device Name:</label>
                            <input class="form-control form-control-sm" name="device_name" type="text"
                                value="{{ old('device_name') }}" placeholder="input the frequency number.." required>
                        </div>
                        <div class="form-group">
                            <label for="cal_status" class="font-weight-bold">Status</label>
                            <select class="form-control form-control-sm" name="cal_status" required>
                                <option value="Internal" @if(old('cal_status') == 'Internal') selected @endif>Internal</option>
                                <option value="External" @if(old('cal_status') == 'External') selected @endif>External</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="freq_cal_num" class="font-weight-bold">Frequency:</label>
                            <input class="form-control form-control-sm" name="freq_cal_num" type="text"
                                value="{{ old('freq_cal_num') }}" placeholder="input the frequency number.." required>
                        </div>
                        <div class="form-group">
                            <label for="life_time_num" class="font-weight-bold">Life Time:</label>
                            <input class="form-control form-control-sm" name="life_time_num" type="text"
                                value="{{ old('life_time_num') }}" placeholder="input the frequency number.." required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="level" value="admin">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" style="font-weight: bold; font-size: 12px; background-color: black;">Back</button>
                        <button type="submit" class="btn btn-primary" style="font-weight: bold; font-size: 12px; background-color: #187dca">Add Measuring DeviceS</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
