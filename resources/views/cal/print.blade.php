@extends('layouts.app', [
    'class' => 'sidebar-mini ',
    'namePage' => 'Calibration',
    'activePage' => 'calibration',
    'activeNav' => '',
])
@section('content')

    <div class="panel-header-sm">
    </div>
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Control Measuring Device</h4>
                        <div class="col-12 mt-2"></div>

                    </div>

                    <div class="card-body">
                        <div class="toolbar">
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                        </div>


                        <div class="table-responsive">
                            @if ($measuring_device && $calibration->count() > 0)
                                <div class="invoice-box">
                                    <div class="table-responsive">
                                        <table id="example" class="table table-striped table-bordered" cellspacing="0"
                                            width="100%">
                                            <thead class="text-center" style="font-size: 10px;">
                                                <tr>
                                                    <th class="hidden" colspan="3">No Control: {{ $measuring_device->no_control }}</th>
                                                    <th class="hidden" colspan="3">Range: {{ $measuring_device->range->range }}</th>
                                                    <th class="hidden" colspan="3">Merk: {{ $measuring_device->merk->merk }}</th>
                                                </tr>
                                                <tr>
                                                    <th  colspan="3">Device Name: {{ $measuring_device->freq->device_name }}</th>
                                                    <th  colspan="3">Resolution: {{ $measuring_device->resolution->resolution }}</th>
                                                    <th  colspan="3">No Seri: {{ $measuring_device->no_seri }}</th>
                                                </tr>
                                                <tr>
                                                    <th  colspan="3">Type: {{ $measuring_device->type->type }}</th>
                                                    <th colspan="3">ATA SAI: {{ $measuring_device->ata_sai}}</th>
                                                    <th class="hidden" colspan="3">Invoice No: {{ $measuring_device->inv_no }}</th>
                                                </tr>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Calibration Date</th>
                                                    <th>No.Certificate</th>
                                                    <th>Result</th>
                                                    <th>Area</th>
                                                    <th>Carname</th>
                                                    <th>Next Calibration</th>
                                                    <th>nik</th>
                                                    <th class="disabled-sorting notexport">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($calibration as $value)
                                                    <tr class="details">
                                                        <td>{{ $value->id }}</td>
                                                        <td>{{ $value->cal_date }}</td>
                                                        <td>{{ $value->no_certificate }}</td>
                                                        <td>{{ $value->con_after_cal }}</td>
                                                        <td>{{ $value->area->area }}</td>
                                                        <td>{{ $value->carname->carname }}</td>
                                                        <td>{{ $value->next_cal }}</td>
                                                        <td>{{ $value->nik }}</td>
                                                        <td>
                                                        <button type="button" class="btn btn-success btn-icon btn-sm" data-toggle="modal" data-target="#editCalibration' + row.id + '"><i class="fas fa-pencil-alt"></i></button>
                                                        <button type="button" class="btn btn-danger btn-icon btn-sm deleteBtn" data-toggle="modal" data-target="#deleteCalibration' + row.id + '"><i class="fas fa-trash-alt"></i></button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @else
                                <p>No device or calibrations found.</p>
                            @endif
                        </div>
                    </div>

                    </div>
                </div>
            </div>
        </div>
    @endsection
