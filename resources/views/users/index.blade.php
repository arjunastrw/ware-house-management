@extends('layouts.app', [
    'namePage' => 'User Management',
    'class' => 'sidebar-mini ',
    'activePage' => 'user',
    'activeNav' => '',
])
<!-- End Navbar -->
@section('content')

    <div class="panel-header-sm">
    </div>
    <div class="content">
        <div class="row">
            <div class="col-md-12" id="users-table">
                <div class="card">
                    <div class="card-header">
                        <a class="btn btn-primary btn-round text-white pull-right font-weight-bold" data-toggle="modal"
                            data-target="#createUser" href="#" style="background-color: #1a7fcd; font-size: 12px"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add Inspector</a>
                        <h4 class="card-title font-weight-bold">Users</h4>
                    </div>
                    @include('users.create')
                    {{-- @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <p ><i class="fa fa-info-circle"></i>&nbsp;&nbsp;{{ $message }}</p>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif --}}
                @if ($message = Session::get('success'))
                    <div id="autoCloseAlert" class="alert alert-success alert-dismissible fade show mx-auto">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <p>{{ $message }}</p>
                    </div>
                    <script>
                        // Auto close the alert after 20 seconds
                        setTimeout(function() {
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
                    <div class="card-body">
                        <div class="toolbar">
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                        </div>
                        <table id="userTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead class="text-center">
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>NIK</th>
                                    <th>Username</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th class="disabled-sorting">Actions</th>
                                </tr>
                            </thead>
{{--                            <tfoot class="text-center">--}}
{{--                                <tr>--}}
{{--                                    <th>No</th>--}}
{{--                                    <th>Nama</th>--}}
{{--                                    <th>NIK</th>--}}
{{--                                    <th>Username</th>--}}
{{--                                    <th>Role</th>--}}
{{--                                    <th>Status</th>--}}
{{--                                    <th class="disabled-sorting">Actions</th>--}}
{{--                                </tr>--}}
{{--                            </tfoot>--}}
                            <tbody>
                                <tr>
                                    @if (!empty($users) && $users->count())
                                        @foreach ($users as $key => $value)
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $value->name }}</td>
                                            <td>{{ $value->nik }}</td>
                                            <td>{{ $value->username }}</td>
                                            <td class="text-center">{{ $value->roles }}</td>
                                            <td class="text-center">
                                                @if (Cache::has('user-online' . $value->id))
                                                    <span class="badge badge-sm badge-success">Online</span>
                                                @else
                                                    <span class="badge badge-sm badge-secondary">Offline</span>
                                                @endif
                                            </td>

                                            <td class="text-center">
                                                <button type="button" class="btn btn-success btn-icon btn-sm"
                                                    data-toggle="modal" data-target="#editUser{{ $value->id }}">
                                                    <i class='fa fa-edit'></i>
                                                </button>
                                                @include('users.edit')
                                                <button type="button" class="btn btn-danger btn-icon btn-sm"
                                                    data-toggle="modal" data-target="#deleteUser{{ $value->id }}">
                                                    <i class="fa fa-trash-alt" aria-hidden="true"></i>
                                                </button>
                                            </td>
                                            @include('users.delete')


                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <!-- end content-->
                </div>
                <!--  end card  -->
            </div>
            <!-- end col-md-12 -->
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#userTable').DataTable();
        })
    </script>
@endsection
