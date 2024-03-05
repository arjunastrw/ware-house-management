@extends('layouts.app', [
'class' => 'sidebar-mini ',
'namePage' => 'User Profile',
'activePage' => 'profile',
'activeNav' => '',
])

@section('content')
<div class="panel-header-sm">
</div>
<div class="content">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
{{--                    <h5 class="title">{{ __('Profile') }}</h5>--}}
{{--                </div>--}}
{{--                <div class="card-body">--}}

{{--                    <div class="row">--}}
{{--                    </div>--}}
{{--                    <div class="row">--}}
{{--                        <div class="col-md-7 pr-1">--}}
{{--                            <div class="form-group">--}}
{{--                                <label>{{ __('Name') }}</label>--}}
{{--                                <div class="readonly-text">{{ auth()->user()->name }}</div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="row">--}}
{{--                        <div class="col-md-7 pr-1">--}}
{{--                            <div class="form-group">--}}
{{--                                <label>{{ __('NIK') }}</label>--}}
{{--                                <div class="readonly-text">{{ auth()->user()->nik }}</div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                    <div class="row">--}}
{{--                        <div class="col-md-7 pr-1">--}}
{{--                            <div class="form-group">--}}
{{--                                <label>{{ __('Username') }}</label>--}}
{{--                                <div class="readonly-text">{{ auth()->user()->username }}</div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                    <div class="row">--}}
{{--                        <div class="col-md-7 pr-1">--}}
{{--                            <div class="form-group">--}}
{{--                                <label for="role">{{ __('Role') }}</label>--}}
{{--                                <div class="readonly-text">{{ auth()->user()->roles }}</div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}


                </div>
                <div class="card-header">
                    <h5 class="title">{{ __('Password') }}</h5>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('profile.update', ['profile' => auth()->user()->id]) }}" autocomplete="off">
                        @csrf
                        @method('put')
                        @include('alerts.success', ['key' => 'password_status'])
                        <div class="row">
                            <div class="col-md-7 pr-1">
                                <!-- old password     -->
                                <div class="form-group">
                                    <label>{{ __(' Current Password') }}</label>
                                    <input class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" name="old_password" placeholder="{{ __('Current Password') }}" type="password" required>
                                    <!-- @include('alerts.feedback', ['field' => 'old_password']) -->
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!-- new password -->
                            <div class="col-md-7 pr-1">
                                <div class="form-group">
                                    <label>{{ __(' New password') }}</label>
                                    <input class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="{{ __('New Password') }}" type="password" name="password" required>
                                    <!-- @include('alerts.feedback', ['field' => 'password']) -->
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!-- new password confirm -->
                            <div class="col-md-7 pr-1">
                                <div class="form-group {{ $errors->has('password') ? ' has-danger' : '' }}">
                                    <label>{{ __(' Confirm New Password') }}</label>
                                    <input class="form-control" placeholder="{{ __('Confirm New Password') }}" type="password" name="password_confirmation" required>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer ">
                            <button type="submit" class="btn btn-primary btn-round font-weight-bold" style=" background-color: #168eea;">{{ __('Change Password') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
{{--        container right--}}
        <div class="col-md-4">
            <div class="card card-user">
                <div class="card-body">
                    <div class="author mt-4" style="font-family: 'Poppins', sans-serif; font-weight: bold; text-align: left;">
                        <a href="#" class="text-dark">
                            <h5 class="title">Username: {{ auth()->user()->username }}</h5>
                            <h5 class="title">Name: {{ auth()->user()->name }}</h5>
                            <h5 class="title">NIK: {{ auth()->user()->nik }}</h5>
                            <h5 class="title">Role: {{ auth()->user()->roles }}</h5>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('layouts.footer')

@endsection
