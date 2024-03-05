@extends('layouts.app', [
'namePage' => 'Sub-Table Management',
'class' => 'sidebar-mini',
'activePage' => 'sub_table',
'activeNav' => '',
])

@section('content')
    <script>
        let tableType = new DataTable('#type');
        let tableMerk = new DataTable('#merk');
        let tableRange = new DataTable('#range');
        let tableResolution = new DataTable('#resolution');
        let tableArea = new DataTable('#area');
        let tableCar = new DataTable('#carname');
    </script>
    <div class="panel-header-sm"></div>
    <div class="content">
        <div class="row">
            <div class="col-md-12" id="users-table">
                <div class="card">
                    <div class="card-header">
                        <!-- Tab navigation -->
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a class="nav-link active" id="measuringTab" data-toggle="tab" href="#MeasuringSection">
                                    Measuring Device Sub-Table
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="calTab" data-toggle="tab" href="#calSection">
                                    Calibration Sub-Table
                                </a>
                            </li>
                        </ul>

                        <div class="col-12 mt-2"></div>
                        <br>
                    </div>

                    <div class="card-body" style="padding-top: 0;">
                        <!-- Tab content -->
                        <div class="tab-content mt-4">

                            <!-- Measuring Device Sub-Table Tab -->
                            <div class="tab-pane fade show active" id="MeasuringSection">
                                @if(session('measuring_success'))
                                    <script>
                                        nowuiDashboard.showNotification('top', 'right', "{{ session('measuring_success') }}", 'success');
                                    </script>
                                @endif

                                @if(session('measuring_error'))
                                    <script>
                                        nowuiDashboard.showNotification('top', 'right', "{{ session('measuring_error')['message'] }}", 'danger');
                                    </script>
                                @endif

                                @if ($message = Session::get('measuring_success'))
                                    <div id="autoCloseAlert"
                                         class="alert alert-success alert-dismissible fade show mx-auto">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <p>{{ $message }}</p>
                                    </div>
                                    <script>
                                        // Auto close the alert after 20 seconds
                                        setTimeout(function () {
                                            $('#autoCloseAlert').alert('close');
                                        }, 20000);
                                    </script>
                                @elseif (session('measuring_error'))
                                    <div class="alert alert-danger alert-dismissible fade show mx-auto">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <p>{{ session('measuring_error')['message'] }}</p>
                                    </div>
                                    {{-- <div class="alert alert-danger">
                                                <strong>Error</strong><br><br>
                                                <p>{{ session('error')['message'] }}</p>

                                </div> --}}
                                    {{--                        TABLE TYPE--}}
                                @endif
                                <div class="row">
                                    <div class="col-md-6">
                                        <!-- Table 1 inside Measuring Device Tab -->
                                        <h5>Table Type</h5>
                                        @if(Auth::check() && Auth::user()->roles === 'Admin')
                                            <a class="btn btn-primary btn-round text-white pull-right"
                                               data-toggle="modal" data-target="#createType" href="#"
                                               style="font-size: 12px; background-color:#2f94e2; font-weight: bold">
                                                <i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp; Add Type
                                            </a>
                                            {{-- Tombol upload data type --}}
                                            <form method="POST" action="{{ route('upload.excel.types') }}"
                                                  enctype="multipart/form-data" id="uploadFormType">
                                                @csrf
                                                <div class="input-group d-flex mt-n3">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="excelFileType"
                                                               name="excelFileType[]" required>
                                                        <label class="custom-file-label" for="excelFileType"
                                                               style="width: 20%; margin-left: 15px; margin-top: -45px; width: 30%">Choose
                                                            Excel File(s)</label>
                                                    </div>
                                                    <div class="input-group ml-3 mt-2">
                                                        <button type="submit" class="btn btn-primary"
                                                                style="font-size: 14px; font-weight: 800; background-color: #168eea; margin-top: -40px; height: 40px; border-radius:30px; ">
                                                            <i class="fa fa-upload" aria-hidden="true"></i>&nbsp;Upload
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                            {{-- Popup notifikasi jika tidak ada file yang dimasukkan --}}
                                            <div id="filePopup" class="modal fade" tabindex="-1" role="dialog">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">File Required</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Please choose a file before uploading.
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Close
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <script>
                                                document.getElementById('uploadFormType').addEventListener('submit', function (event) {
                                                    var files = document.getElementById('excelFileType').files;
                                                    if (files.length === 0) {
                                                        // Tampilkan popup jika tidak ada file yang dimasukkan
                                                        $('#filePopup').modal('show');
                                                        // Hentikan pengiriman formulir
                                                        event.preventDefault();
                                                    }
                                                });

                                                document.getElementById('excelFileType').addEventListener('change', function () {
                                                    var fileName = '';
                                                    var files = this.files;
                                                    for (var i = 0; i < files.length; i++) {
                                                        fileName += files[i].name + ', ';
                                                    }
                                                    // Hapus koma ekstra di akhir
                                                    fileName = fileName.slice(0, -2);
                                                    // Update label kustom dengan nama file
                                                    var label = this.nextElementSibling;
                                                    label.textContent = fileName;
                                                });
                                            </script>
                                            {{--                                button end--}}
                                        @endif
                                        <div class="table-responsive" style="max-height: 500px; overflow-y:auto;">
                                            <table id="typeTable"
                                                   class="table table-striped table-striped table-bordered"
                                                   cellspacing="0" style="border:1px;" width="100%">
                                                <thead class="text-center"
                                                       style="position: sticky; top: 0; z-index: 1; backdrop-filter: blur(50px); background-color: rgba(255, 255, 255, 0.8);">
                                                <tr>
                                                    <th>No</th>
                                                    <th>Type</th>
                                                    <th class="disabled-sorting">Actions</th>
                                                </tr>
                                                </thead>
                                                <tbody style="font-size: 11px;">
                                                @if (!empty($types) && $types->count())
                                                    @foreach ($types as $key => $value)
                                                        <tr>
                                                            <td class="text-center">
                                                                {{ $loop->iteration }}
                                                            </td>
                                                            <td>{{ $value->type }}</td>
                                                            <td class="text-center">
                                                                <button type="button"
                                                                        class="btn btn-success btn-icon btn-sm"
                                                                        data-toggle="modal"
                                                                        data-target="#editType{{ $value->id }}">
                                                                    <i class="fas fa-pencil-alt"></i>
                                                                </button>
                                                                <button type="button"
                                                                        class="btn btn-danger btn-icon btn-sm"
                                                                        data-toggle="modal"
                                                                        data-target="#deleteType{{ $value->id }}">
                                                                    <i class="fas fa-trash-alt"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    {{--                            Table Merk--}}
                                    <div class="col-md-6">
                                        <!-- Table 2 inside Measuring Device Tab -->
                                        <h5>Table Merk</h5>
                                        @if(Auth::check() && Auth::user()->roles === 'Admin')
                                            <a class="btn btn-primary btn-round text-white pull-right"
                                               data-toggle="modal" data-target="#createMerk" href="#"
                                               style="font-size: 12px; background-color:#2f94e2; font-weight: bold">
                                                <i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp; Add Merk
                                            </a>

                                            {{-- Tombol upload data merk --}}
                                            <form method="POST" action="{{ route('upload.excel.merks') }}"
                                                  enctype="multipart/form-data" id="uploadFormMerk">
                                                @csrf
                                                <div class="input-group d-flex mt-n3">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="excelFileMerk"
                                                               name="excelFileMerk[]" required>
                                                        <label class="custom-file-label" for="excelFileMerk"
                                                               style="width: 20%; margin-left: 15px; margin-top: -45px; width: 30%">Choose
                                                            Excel File(s)</label>
                                                    </div>
                                                    <div class="input-group ml-3 mt-2">
                                                        <button type="submit" class="btn btn-primary"
                                                                style="font-size: 14px; font-weight: 800; background-color: #168eea; margin-top: -40px; height: 40px; border-radius:30px; ">
                                                            <i class="fa fa-upload" aria-hidden="true"></i>&nbsp;Upload
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                            {{-- Popup notifikasi jika tidak ada file yang dimasukkan --}}
                                            <div id="filePopup" class="modal fade" tabindex="-1" role="dialog">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">File Required</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Please choose a file before uploading.
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Close
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <script>
                                                document.getElementById('uploadFormMerk').addEventListener('submit', function (event) {
                                                    var files = document.getElementById('excelFileMerk').files;
                                                    if (files.length === 0) {
                                                        // Tampilkan popup jika tidak ada file yang dimasukkan
                                                        $('#filePopup').modal('show');
                                                        // Hentikan pengiriman formulir
                                                        event.preventDefault();
                                                    }
                                                });

                                                document.getElementById('excelFileMerk').addEventListener('change', function () {
                                                    var fileName = '';
                                                    var files = this.files;
                                                    for (var i = 0; i < files.length; i++) {
                                                        fileName += files[i].name + ', ';
                                                    }
                                                    // Hapus koma ekstra di akhir
                                                    fileName = fileName.slice(0, -2);
                                                    // Update label kustom dengan nama file
                                                    var label = this.nextElementSibling;
                                                    label.textContent = fileName;
                                                });
                                            </script>
                                            {{--                                button end--}}
                                        @endif
                                        <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                                            <table id="merk" class="table table-striped table-bordered"
                                                   cellspacing="0" width="100%">
                                                <thead class="text-center"
                                                       style="position: sticky; top: 0; z-index: 1; backdrop-filter: blur(50px); background-color: rgba(255, 255, 255, 0.8);">
                                                <tr>
                                                    <th>No</th>
                                                    <th>Merk</th>
                                                    <th class="disabled-sorting">Actions</th>
                                                </tr>
                                                </thead>
                                                <tbody style="font-size: 11px;">
                                                @if (!empty($merks) && $merks->count())
                                                    @foreach ($merks as $key => $value)
                                                        <tr>
                                                            <td class="text-center">
                                                                {{ $loop->iteration }}
                                                            </td>
                                                            <td>{{ $value->merk }}</td>
                                                            <td class="text-center">
                                                                <button type="button"
                                                                        class="btn btn-success btn-icon btn-sm"
                                                                        data-toggle="modal"
                                                                        data-target="#editMerk{{ $value->id }}">
                                                                    <i class="fas fa-pencil-alt"></i>
                                                                </button>
                                                                <button type="button"
                                                                        class="btn btn-danger btn-icon btn-sm"
                                                                        data-toggle="modal"
                                                                        data-target="#deleteMerk{{ $value->id }}">
                                                                    <i class="fas fa-trash-alt"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                {{--                                TABLE RANGE--}}
                                <div class="row mt-4">
                                    <div class="col-md-6">
                                        <!-- Table 3 inside Measuring Device Tab -->
                                        <h5>Table Range</h5>
                                        @if(Auth::check() && Auth::user()->roles === 'Admin')
                                            <a class="btn btn-primary btn-round text-white pull-right"
                                               data-toggle="modal"
                                               data-target="#createRange" href="#"
                                               style="font-size: 12px; background-color:#2f94e2; font-weight: bold">
                                                <i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp; Add Range
                                            </a>

                                            {{-- Tombol upload data range --}}
                                            <form method="POST" action="{{ route('upload.excel.ranges') }}"
                                                  enctype="multipart/form-data" id="uploadFormRange">
                                                @csrf
                                                <div class="input-group d-flex mt-n3">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="excelFileRange"
                                                               name="excelFileRange[]" required>
                                                        <label class="custom-file-label" for="excelFileRange"
                                                               style="width: 20%; margin-left: 15px; margin-top: -45px; width: 30%">Choose
                                                            Excel File(s)</label>
                                                    </div>
                                                    <div class="input-group ml-3 mt-2">
                                                        <button type="submit" class="btn btn-primary"
                                                                style="font-size: 14px; font-weight: 800; background-color: #168eea; margin-top: -40px; height: 40px; border-radius:30px; ">
                                                            <i class="fa fa-upload" aria-hidden="true"></i>&nbsp;Upload
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                            {{-- Popup notifikasi jika tidak ada file yang dimasukkan --}}
                                            <div id="filePopup" class="modal fade" tabindex="-1" role="dialog">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">File Required</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Please choose a file before uploading.
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Close
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <script>
                                                document.getElementById('uploadFormRange').addEventListener('submit', function (event) {
                                                    var files = document.getElementById('excelFileRange').files;
                                                    if (files.length === 0) {
                                                        // Tampilkan popup jika tidak ada file yang dimasukkan
                                                        $('#filePopup').modal('show');
                                                        // Hentikan pengiriman formulir
                                                        event.preventDefault();
                                                    }
                                                });

                                                document.getElementById('excelFileRange').addEventListener('change', function () {
                                                    var fileName = '';
                                                    var files = this.files;
                                                    for (var i = 0; i < files.length; i++) {
                                                        fileName += files[i].name + ', ';
                                                    }
                                                    // Hapus koma ekstra di akhir
                                                    fileName = fileName.slice(0, -2);
                                                    // Update label kustom dengan nama file
                                                    var label = this.nextElementSibling;
                                                    label.textContent = fileName;
                                                });
                                            </script>
                                            {{--                                button end--}}
                                        @endif

                                        <div class="table-responsive" style="max-height: 500px; overflow-y: auto">
                                            <table id="range" class="table table-striped table-bordered" cellspacing="0"
                                                   width="100%">
                                                <thead class="text-center"
                                                       style="position: sticky; top: 0; z-index: 1; backdrop-filter: blur(50px); background-color: rgba(255, 255, 255, 0.8);">
                                                <tr>
                                                    <th>No</th>
                                                    <th>Range</th>
                                                    <th class="disabled-sorting">Actions</th>
                                                </tr>
                                                </thead>
                                                <tbody style="font-size: 11px;">
                                                @if (!empty($ranges) && $ranges->count())
                                                    @foreach ($ranges as $key => $value)
                                                        <tr>
                                                            <td class="text-center">
                                                                {{ $loop->iteration }}
                                                            </td>
                                                            <td>{{ $value->range }}</td>
                                                            <td class="text-center">
                                                                <button type="button"
                                                                        class="btn btn-success btn-icon btn-sm"
                                                                        data-toggle="modal"
                                                                        data-target="#editRange{{ $value->id }}">
                                                                    <i class="fas fa-pencil-alt"></i>
                                                                </button>
                                                                <button type="button"
                                                                        class="btn btn-danger btn-icon btn-sm"
                                                                        data-toggle="modal"
                                                                        data-target="#deleteRange{{ $value->id }}">
                                                                    <i class="fas fa-trash-alt"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    {{--                            TABLE RESOLUTION--}}
                                    <div class="col-md-6">
                                        <!-- Table 4 inside Measuring Device Tab -->
                                        <h5>Table Resolution</h5>
                                        @if(Auth::check() && Auth::user()->roles === 'Admin')
                                            <a class="btn btn-primary btn-round text-white pull-right"
                                               data-toggle="modal"
                                               data-target="#createResolution" href="#"
                                               style="font-size: 12px; background-color:#2f94e2; font-weight: bold">
                                                <i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp; Add
                                                Resolution
                                            </a>

                                            {{-- Tombol upload data merk --}}
                                            <form method="POST" action="{{ route('upload.excel.resolutions') }}"
                                                  enctype="multipart/form-data" id="uploadFormResolution">
                                                @csrf
                                                <div class="input-group d-flex mt-n3">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input"
                                                               id="excelFileResolution" name="excelFileResolution[]"
                                                               required>
                                                        <label class="custom-file-label" for="excelFileResolution"
                                                               style="width: 20%; margin-left: 15px; margin-top: -45px; width: 30%">Choose
                                                            Excel File(s)</label>
                                                    </div>
                                                    <div class="input-group ml-3 mt-2">
                                                        <button type="submit" class="btn btn-primary"
                                                                style="font-size: 14px; font-weight: 800; background-color: #168eea; margin-top: -40px; height: 40px; border-radius:30px; ">
                                                            <i class="fa fa-upload" aria-hidden="true"></i>&nbsp;Upload
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                            {{-- Popup notifikasi jika tidak ada file yang dimasukkan --}}
                                            <div id="filePopup" class="modal fade" tabindex="-1" role="dialog">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">File Required</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Please choose a file before uploading.
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Close
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <script>
                                                document.getElementById('uploadFormResolution').addEventListener('submit', function (event) {
                                                    var files = document.getElementById('excelFileResolution').files;
                                                    if (files.length === 0) {
                                                        // Tampilkan popup jika tidak ada file yang dimasukkan
                                                        $('#filePopup').modal('show');
                                                        // Hentikan pengiriman formulir
                                                        event.preventDefault();
                                                    }
                                                });

                                                document.getElementById('excelFileResolution').addEventListener('change', function () {
                                                    var fileName = '';
                                                    var files = this.files;
                                                    for (var i = 0; i < files.length; i++) {
                                                        fileName += files[i].name + ', ';
                                                    }
                                                    // Hapus koma ekstra di akhir
                                                    fileName = fileName.slice(0, -2);
                                                    // Update label kustom dengan nama file
                                                    var label = this.nextElementSibling;
                                                    label.textContent = fileName;
                                                });
                                            </script>
                                            {{--                                button end--}}
                                        @endif
                                        <div class="table-responsive" style="max-height: 500px; overflow-y: auto">
                                            <table id="resolution" class="table table-striped table-bordered"
                                                   cellspacing="0" width="100%">
                                                <thead class="text-center"
                                                       style="position: sticky; top: 0; z-index: 1; backdrop-filter: blur(50px); background-color: rgba(255, 255, 255, 0.8);">
                                                <tr>
                                                    <th>No</th>
                                                    <th>Resolution</th>
                                                    <th class="disabled-sorting">Actions</th>
                                                </tr>
                                                </thead>
                                                <tbody style="font-size: 11px;">
                                                @if (!empty($resolutions) && $ranges->count())
                                                    @foreach ($resolutions as $key => $value)
                                                        <tr>
                                                            <td class="text-center">
                                                                {{ $loop->iteration }}
                                                            </td>
                                                            <td>{{ $value->resolution }}</td>
                                                            <td class="text-center">
                                                                <button type="button"
                                                                        class="btn btn-success btn-icon btn-sm"
                                                                        data-toggle="modal"
                                                                        data-target="#editResolution{{ $value->id }}">
                                                                    <i class="fas fa-pencil-alt"></i>
                                                                </button>
                                                                <button type="button"
                                                                        class="btn btn-danger btn-icon btn-sm"
                                                                        data-toggle="modal"
                                                                        data-target="#deleteResolution{{ $value->id }}">
                                                                    <i class="fas fa-trash-alt"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Calibration Sub-Table Tab -->
                            <div class="tab-pane fade" id="calSection">
                                @if(session('measuring_success'))
                                    <script>
                                        nowuiDashboard.showNotification('top', 'right', "{{ session('measuring_success') }}", 'success');
                                    </script>
                                @endif

                                @if(session('measuring_error'))
                                    <script>
                                        nowuiDashboard.showNotification('top', 'right', "{{ session('measuring_error')['message'] }}", 'danger');
                                    </script>
                                @endif
                                @if ($message = Session::get('success'))
                                    <div id="autoCloseAlert"
                                         class="alert alert-success alert-dismissible fade show mx-auto">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <p>{{ $message }}</p>
                                    </div>
                                    <script>
                                        // Auto close the alert after 20 seconds
                                        setTimeout(function () {
                                            $('#autoCloseAlert').alert('close');
                                        }, 20000);
                                    </script>
                                @elseif (session('error'))
                                    <div class="alert alert-danger alert-dismissible fade show mx-auto">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <p>{{ session('error')['message'] }}</p>
                                    </div>
                                    {{-- <div class="alert alert-danger">
                                                    <strong>Error</strong><br><br>
                                                    <p>{{ session('error')['message'] }}</p>

                                </div> --}}
                                @endif
                                <!-- Content for Calibration Sub-Table goes here -->
                                <div class="row">
                                    <!-- Table Area inside Calibration Tab -->
                                    <div class="col-md-6">
                                        <h5>Table Area</h5>
                                        @if(Auth::check() && Auth::user()->roles === 'Admin')
                                            <a class="btn btn-primary btn-round text-white pull-right"
                                               data-toggle="modal"
                                               data-target="#createArea" href="#"
                                               style="font-size: 12px; background-color:#2f94e2; font-weight: bold">
                                                <i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp; Add Area
                                            </a>

                                            {{-- Tombol upload data area --}}
                                            <form method="POST" action="{{ route('upload.excel.areas') }}"
                                                  enctype="multipart/form-data" id="uploadFormArea">
                                                @csrf
                                                <div class="input-group d-flex mt-n3">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="excelFileArea"
                                                               name="excelFileArea[]" required>
                                                        <label class="custom-file-label" for="excelFileArea"
                                                               style="width: 20%; margin-left: 15px; margin-top: -45px; width: 30%">Choose
                                                            Excel File(s)</label>
                                                    </div>
                                                    <div class="input-group ml-3 mt-2">
                                                        <button type="submit" class="btn btn-primary"
                                                                style="font-size: 14px; font-weight: 800; background-color: #168eea; margin-top: -40px; height: 40px; border-radius:30px; ">
                                                            <i class="fa fa-upload" aria-hidden="true"></i>&nbsp;Upload
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                            {{-- Popup notifikasi jika tidak ada file yang dimasukkan --}}
                                            <div id="filePopup" class="modal fade" tabindex="-1" role="dialog">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">File Required</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Please choose a file before uploading.
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Close
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <script>
                                                document.getElementById('uploadFormArea').addEventListener('submit', function (event) {
                                                    var files = document.getElementById('excelFileArea').files;
                                                    if (files.length === 0) {
                                                        // Tampilkan popup jika tidak ada file yang dimasukkan
                                                        $('#filePopup').modal('show');
                                                        // Hentikan pengiriman formulir
                                                        event.preventDefault();
                                                    }
                                                });

                                                document.getElementById('excelFileArea').addEventListener('change', function () {
                                                    var fileName = '';
                                                    var files = this.files;
                                                    for (var i = 0; i < files.length; i++) {
                                                        fileName += files[i].name + ', ';
                                                    }
                                                    // Hapus koma ekstra di akhir
                                                    fileName = fileName.slice(0, -2);
                                                    // Update label kustom dengan nama file
                                                    var label = this.nextElementSibling;
                                                    label.textContent = fileName;
                                                });
                                            </script>
                                            {{--                                button end--}}
                                        @endif
                                        <div class="table-responsive" style="max-height: 1000px">
                                            <table id="area" class="table table-striped table-bordered" cellspacing="0"
                                                   width="100%">
                                                <thead class="text-center"
                                                       style="position: sticky; top: 0; z-index: 1; backdrop-filter: blur(50px); background-color: rgba(255, 255, 255, 0.8);">
                                                <tr>
                                                    <th>No</th>
                                                    <th>Area</th>
                                                    <th class="disabled-sorting">Actions</th>
                                                </tr>
                                                </thead>
                                                <tbody style="font-size: 11px;">
                                                @if (!empty($areas) && $areas->count())
                                                    @foreach ($areas as $key => $value)
                                                        <tr>
                                                            <td class="text-center">
                                                                {{ $loop->iteration }}
                                                            </td>
                                                            <td>{{ $value->area }}</td>
                                                            <td class="text-center">
                                                                <button type="button"
                                                                        class="btn btn-success btn-icon btn-sm"
                                                                        data-toggle="modal"
                                                                        data-target="#editArea{{ $value->id }}">
                                                                    <i class="fas fa-pencil-alt"></i>
                                                                </button>
                                                                <button type="button"
                                                                        class="btn btn-danger btn-icon btn-sm"
                                                                        data-toggle="modal"
                                                                        data-target="#deleteArea{{ $value->id }}">
                                                                    <i class="fas fa-trash-alt"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <!-- Table Carname inside Calibration Tab -->
                                    <div class="col-md-6">
                                        <h5>Table Carname</h5>
                                        @if(Auth::check() && Auth::user()->roles === 'Admin')

                                            <a class="btn btn-primary btn-round text-white pull-right"
                                               data-toggle="modal"
                                               data-target="#createCarname" href="#"
                                               style="font-size: 12px; background-color:#2f94e2; font-weight: bold">
                                                <i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp; Add Carname
                                            </a>

                                            {{-- Tombol upload data carname --}}
                                            <form method="POST" action="{{ route('upload.excel.carnames') }}"
                                                  enctype="multipart/form-data" id="uploadFormCarName">
                                                @csrf
                                                <div class="input-group d-flex mt-n3">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input"
                                                               id="excelFileCarName"
                                                               name="excelFileCarName[]" required>
                                                        <label class="custom-file-label" for="excelFileCarName"
                                                               style="width: 20%; margin-left: 15px; margin-top: -45px; width: 30%">Choose
                                                            Excel File(s)</label>
                                                    </div>
                                                    <div class="input-group ml-3 mt-2">
                                                        <button type="submit" class="btn btn-primary"
                                                                style="font-size: 14px; font-weight: 800; background-color: #168eea; margin-top: -40px; height: 40px; border-radius:30px; ">
                                                            <i class="fa fa-upload" aria-hidden="true"></i>&nbsp;Upload
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                            {{-- Popup notifikasi jika tidak ada file yang dimasukkan --}}
                                            <div id="filePopup" class="modal fade" tabindex="-1" role="dialog">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">File Required</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Please choose a file before uploading.
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Close
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <script>
                                                document.getElementById('uploadFormCarName').addEventListener('submit', function (event) {
                                                    var files = document.getElementById('excelFileCarName').files;
                                                    if (files.length === 0) {
                                                        // Tampilkan popup jika tidak ada file yang dimasukkan
                                                        $('#filePopup').modal('show');
                                                        // Hentikan pengiriman formulir
                                                        event.preventDefault();
                                                    }
                                                });

                                                document.getElementById('excelFileCarName').addEventListener('change', function () {
                                                    var fileName = '';
                                                    var files = this.files;
                                                    for (var i = 0; i < files.length; i++) {
                                                        fileName += files[i].name + ', ';
                                                    }
                                                    // Hapus koma ekstra di akhir
                                                    fileName = fileName.slice(0, -2);
                                                    // Update label kustom dengan nama file
                                                    var label = this.nextElementSibling;
                                                    label.textContent = fileName;
                                                });
                                            </script>
                                            {{--                                button end--}}
                                        @endif
                                        <div class="table-responsive" style="max-height: 1000px; overflow-y: auto;">
                                            <table id="carname" class="table table-striped table-bordered"
                                                   cellspacing="0" width="100%">
                                                <thead class="text-center"
                                                       style="position: sticky; top: 0; z-index: 1; backdrop-filter: blur(50px); background-color: rgba(255, 255, 255, 0.8);">
                                                <tr>
                                                    <th>No</th>
                                                    <th>Carname</th>
                                                    <th class="disabled-sorting">Actions</th>
                                                </tr>
                                                </thead>
                                                <tbody style="font-size: 11px;">
                                                @if (!empty($carnames) && $carnames->count())
                                                    @foreach ($carnames as $key => $value)
                                                        <tr>
                                                            <td class="text-center">
                                                                {{ $loop->iteration }}
                                                            </td>
                                                            <td>{{ $value->carname }}</td>
                                                            <td class="text-center">
                                                                <button type="button"
                                                                        class="btn btn-success btn-icon btn-sm"
                                                                        data-toggle="modal"
                                                                        data-target="#editCarname{{ $value->id }}">
                                                                    <i class="fas fa-pencil-alt"></i>
                                                                </button>
                                                                <button type="button"
                                                                        class="btn btn-danger btn-icon btn-sm"
                                                                        data-toggle="modal"
                                                                        data-target="#deleteCarname{{ $value->id }}">
                                                                    <i class="fas fa-trash-alt"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end content-->

                        @include('sub_table.create')
                        @include('sub_table.edit')
                        @include('sub_table.delete')
                    </div>
                    <!--  end card  -->
                </div>
                <!-- end col-md-12 -->
            </div>
            <!-- end row -->
        </div>
    </div>

@endsection
