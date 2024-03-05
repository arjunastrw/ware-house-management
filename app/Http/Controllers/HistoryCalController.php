<?php

namespace App\Http\Controllers;

use App\Models\MeasuringDevice;
use App\Models\Calibration;
use App\Exports\HistoryCalExport;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class HistoryCalController extends Controller
{
    public function data()
    {
        $query = Calibration::with('measuringDevice.freq', 'area', 'carname');
        return DataTables::of($query)->toJson();
    }
    public function index(Request $request)
    {
        // Pagination
        $calibration = Calibration::all();
        $measuring_device = MeasuringDevice::all();
        return view('calibration_history.index', compact('measuring_device', 'calibration'));
    }

    public function print($id){
        $measuring_device = MeasuringDevice::findOrFail($id);
        $calibration = Calibration::where('measuring_device_id', $id)->get();

        return view('cal.print', compact('measuring_device', 'calibration'));
    }


    public function export($id)
    {
        $measuringDevice = MeasuringDevice::findOrFail($id);
        $calibration = Calibration::where('measuring_device_id', $id)->get();
        return Excel::download(new HistoryCalExport($measuringDevice, $calibration), 'calibration.xlsx');
    }


}
