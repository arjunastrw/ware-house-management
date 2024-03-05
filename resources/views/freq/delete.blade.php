    <div class="modal fade" id="deleteFreq{{ $value->id }}" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Delete Frequency</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('freq.destroy', $value->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('DELETE')
                        <div class="modal-body">Are you sure to delete this device with name
                            <br>
                            <b>{{ $value->device_name }}</b>?
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
