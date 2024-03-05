   <div class="modal fade" id="deleteCalibration{{ $calibration->id }}" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Delete Calibration</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('calibrations.destroy', $calibration->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('DELETE')
                        <div class="modal-body">Are you sure to delete this device with number control
                            <br>
                            <b>{{ $calibration->measuringDevice->no_control }} - {{ $calibration->measuringDevice->freq->device_name }}</b>?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger">Delete Device</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
