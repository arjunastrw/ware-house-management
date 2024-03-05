@foreach ($types as $type)
    <div class="modal fade" id="editType{{ $type->id }}" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Edit Type</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('types.update', $type->id) }}">
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
                                <label for="type">Type:</label>
                                <input class="form-control form-control-sm" name="type" type="text"
                                    placeholder="input the no type.." value="{{ $type->type }}"
                                    required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach

@foreach ($merks as $merk)
    <div class="modal fade" id="editMerk{{ $merk->id }}" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Edit Merk</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('merks.update', $merk->id) }}">
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
                                <label for="merk">Merk:</label>
                                <input class="form-control form-control-sm" name="merk" type="text"
                                    placeholder="input the merk.." value="{{ $merk->merk }}"
                                    required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach


@foreach ($ranges as $range)
    <div class="modal fade" id="editRange{{ $range->id }}" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Edit Range</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('ranges.update', $range->id) }}">
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
                                <label for="range">Range:</label>
                                <input class="form-control form-control-sm" name="range" type="text"
                                    placeholder="input the range.." value="{{ $range->range }}"
                                    required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach

@foreach ($resolutions as $resolution)
    <div class="modal fade" id="editResolution{{ $resolution->id }}" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Edit Resolution</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('resolutions.update', $resolution->id) }}">
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
                                <label for="resolution">Resolution:</label>
                                <input class="form-control form-control-sm" name="resolution" type="text"
                                    placeholder="input the resolution.." value="{{ $resolution->resolution }}"
                                    required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach

@foreach ($areas as $area)
    <div class="modal fade" id="editArea{{ $area->id }}" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Edit Area</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('areas.update', $area->id) }}#calSection">
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
                                <label for="area">Area:</label>
                                <input class="form-control form-control-sm" name="area" type="text"
                                    placeholder="input the no type.." value="{{ $area->area }}"
                                    required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach

@foreach ($carnames as $carname)
    <div class="modal fade" id="editCarname{{ $carname->id }}" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Edit Carname</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('carnames.update', $carname->id) }}#calSection">
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
                                <label for="carname">Carname:</label>
                                <input class="form-control form-control-sm" name="carname" type="text"
                                    placeholder="input the carname.." value="{{ $carname->carname }}"
                                    required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach

