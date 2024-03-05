 <div class="modal fade" id="createType" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="exampleModalLongTitle">Add Type</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

            </div>

            <div class="modal-body" >
                <form method="POST" action="{{ route('types.store') }}">
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
                            <label for="type" style="color: black">Type :</label>
                            <input class="form-control form-control-sm" name="type" type="text"
                                value="{{ old('type') }}" placeholder="input the type.." required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="level" value="admin">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" style="background-color: black; font-weight: bold">Back</button>
                        <button type="submit" class="btn btn-primary" style="background-color: #268bd9; font-weight: bold">Add Type</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="createMerk" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="exampleModalLongTitle">Add Merk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

            </div>

            <div class="modal-body" >
                <form method="POST" action="{{ route('merks.store') }}">
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
                            <label for="merk" style="color: black">Merk :</label>
                            <input class="form-control form-control-sm" name="merk" type="text"
                                value="{{ old('merk') }}" placeholder="input the merk.." required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="level" value="admin">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" style="background-color: black; font-weight: bold">Back</button>
                        <button type="submit" class="btn btn-primary" style="background-color: #268bd9; font-weight: bold">Add Merk</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="createRange" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="exampleModalLongTitle">Add Range</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

            </div>

            <div class="modal-body" >
                <form method="POST" action="{{ route('ranges.store') }}">
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
                            <label for="range" style="color: black">Range :</label>
                            <input class="form-control form-control-sm" name="range" type="text"
                                value="{{ old('range') }}" placeholder="input the range.." required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="level" value="admin">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" style="background-color: black; font-weight: bold">Back</button>
                        <button type="submit" class="btn btn-primary" style="background-color: #268bd9; font-weight: bold">Add Range</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="createResolution" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="exampleModalLongTitle">Add Resolution</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

            </div>

            <div class="modal-body" >
                <form method="POST" action="{{ route('resolutions.store') }}">
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
                            <label for="resolution" style="color: black;">Resolution :</label>
                            <input class="form-control form-control-sm" name="resolution" type="text"
                                value="{{ old('resolution') }}" placeholder="input the resolution.." required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="level" value="admin">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" style="background-color: black; font-weight: bold">Back</button>
                        <button type="submit" class="btn btn-primary" style="background-color: #268bd9; font-weight: bold">Add Resolution</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="createArea" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="exampleModalLongTitle">Add Area</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

            </div>

            <div class="modal-body" >
                <form method="POST" action="{{ route('areas.store') }}#calSection">
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
                            <label for="area" style="color: black">Area :</label>
                            <input class="form-control form-control-sm" name="area" type="text"
                                value="{{ old('area') }}" placeholder="input the area.." required>
                                <input type="hidden" name="active_tab" value="calSection">

                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="level" value="admin">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" style="background-color: black; font-weight: bold">Back</button>
                        <button type="submit" class="btn btn-primary" style="font-weight: bold; background-color: #268bd9;">Add Area</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="createCarname" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="exampleModalLongTitle">Add Carname</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <input type="hidden" name="active_tab" value="calSection">


            </div>

            <div class="modal-body" >
                <form method="POST" action="{{ route('carnames.store') }}#calSection">
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
                            <label for="carname" style="color: black">Carname :</label>
                            <input class="form-control form-control-sm" name="carname" type="text"
                                value="{{ old('carname') }}" placeholder="input the carname.." required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="level" value="admin">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" style="background-color: black; font-weight: bold">Back</button>
                        <button type="submit" class="btn btn-primary" style="font-weight: bold; background-color: #268bd9">Add Carname</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
