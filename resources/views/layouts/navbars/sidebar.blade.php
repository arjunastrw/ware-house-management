@php
$user = Auth::user();
@endphp

<div class="sidebar" id="sidebar-collapse" data-color="blue" aria-expanded="true">
    <div class="logo">
        <a href="#" class="simple-text logo-mini mt-2">
            <img src="{{ asset('/assets/img/cmd2.png') }}"> </a>
        <a href="#" class="simple-text logo-normal font-weight-bold">
            <div>{{ __('CONTROL MEASURING') }}</div>
            <div class="ml-5 mt-n2">{{ __('DEVICE') }}</div>
        </a>
    </div>
    <div class=" sidebar-wrapper" id="sidebar-wrapper">
        <ul class="nav">
            <li class="@if ($activePage == 'dashboard') active @endif">
                <a href="{{ route('dashboard') }}">
                    <i class="now-ui-icons design_app"></i>
                    <p class="font-weight-bold">{{ __('Dashboard') }}</p>
                </a>
            </li>
            @if ($user && $user->hasRole('Inspector'))

            <li class="@if ($activePage == 'profile') active @endif">
                <a href="{{ route('profile.index') }}">
                    <i class="now-ui-icons users_single-02"></i>
                    <p> {{ __('User Profile') }} </p>
                </a>
            </li>
            @endif
            @if ($user && $user->hasRole('Admin'))
            <li >
                <a data-toggle="collapse" style="background-color:whitesmoke" href="#laravelExamples">
                    <i class="fab fa-laravel" style="color:#3095e3"></i>
                    <p class="font-weight-bold" style="color: #3095e3;">
                        {{ __('User') }}
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse show ml-3" id="laravelExamples">
                    <ul class="nav">
                        <li class="@if ($activePage == 'profile') active @endif">
                            <a href="{{ route('profile.index') }}">
                                <i class="now-ui-icons users_single-02"></i>
                                <p class="font-weight-bold"> {{ __('User Profile') }} </p>
                            </a>
                        </li>
                        <li class="@if ($activePage == 'user') active @endif">
                            <a href="{{ route('users.index') }}">
                                <i class="now-ui-icons design_bullet-list-67"></i>
                                <p class="font-weight-bold"> {{ __('User Management') }} </p>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            @endif
            <li>
                <a data-toggle="collapse" style="background-color:whitesmoke" href="#MeasuringDevice">
                    <i class="now-ui-icons design-2_ruler-pencil" style="color: #3095e3;"></i>
                    <p class="font-weight-bold" style="color: #3095e3;">
                        {{ __('Measuring Device') }}
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse show ml-3" id="MeasuringDevice">
                    <ul class="nav">
                        <li class="@if ($activePage == 'measuring_device') active @endif">
                            <a href="{{ route('measuring_devices.index') }}">
                                <i class="now-ui-icons design_bullet-list-67"></i>
                                <p class="font-weight-bold"> {{ __('Measuring Device') }} </p>
                            </a>
                        </li>
                        <li class="@if ($activePage == 'calibration_frequency') active @endif">
                            <a href="{{ route('freq.index') }}">
                                <i class="now-ui-icons ui-1_calendar-60"></i>
                                <p class="font-weight-bold" > {{ __('Calibration Frequency') }} </p>
                            </a>
                        </li>
                        <li class="@if ($activePage == 'sub_table') active @endif">
                            <a href="{{ route('sub_table.index') }}">
                                <i class="now-ui-icons ui-1_calendar-60"></i>
                                <p class="font-weight-bold" > {{ __('Sub Table') }} </p>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li>
                <a data-toggle="collapse" style="background-color:whitesmoke" href="#calibration">
                    <i class="now-ui-icons design-2_ruler-pencil" style="color: #3095e3;"></i>
                    <p class="font-weight-bold" style="color: #3095e3;">
                        {{ __('Calibration') }}
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse show ml-3" id="calibration">
                    <ul class="nav">
                        <li class="@if ($activePage == 'calibration') active @endif">
                            <a href="{{ route('calibrations.index') }}">
                                <i class="now-ui-icons design_bullet-list-67"></i>
                                <p class="font-weight-bold"> {{ __('Control Measuring') }} </p>
                                <p class="font-weight-bold" style="text-align: center"> {{ __('Device') }} </p>
                            </a>
                        </li>
                        <li class="@if ($activePage == 'calibration_history') active @endif">
                            <a href="{{ route('calibration_history.index') }}">
                                <i class="now-ui-icons files_single-copy-04"></i>
                                <p class="font-weight-bold"> {{ __('Measuring Device History') }} </p>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</div>
