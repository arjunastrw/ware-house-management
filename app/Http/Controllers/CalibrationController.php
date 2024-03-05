<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;


use Illuminate\Http\Request;
use App\Models\Calibration;
use App\Models\MeasuringDevice;
use App\Models\FreqCalMeasuringDevice;
use App\Models\Area;
use App\Models\Carname;
use Yajra\DataTables\Facades\DataTables;

class CalibrationController extends Controller
{
    public function data()
    {
        $query = Calibration::with('measuringDevice.freq', 'area', 'carname');
        return DataTables::of($query)
            ->addColumn('action', function ($calibration) {
                return '<button type="button" class="btn btn-success btn-icon btn-sm editBtn" data-toggle="modal" data-target="#editCalibration' . $calibration->id . '"><i class="fas fa-pencil-alt"></i></button>';
            })
            ->toJson();
    }


    public function getAllValue($id)
    {
        try {
            // Temukan perangkat pengukuran berdasarkan ID yang diberikan
            $measuringDevice = MeasuringDevice::findOrFail($id);
            // Ambil nilai no kontrol dari perangkat pengukuran
            $noControl = $measuringDevice->no_control;

            // Kembalikan respons JSON dengan no kontrol
            return response()->json(['no_control' => $noControl]);
        } catch (\Exception $e) {
            // Tangani kesalahan dan kembalikan respons JSON dengan status kode 500 (Internal Server Error)
            return response()->json(['error' => 'Failed to retrieve control number'], 500);
        }
    }

    public function index(Request $request)
    {
        $calibration = Calibration::with('measuringDevice')->get();

        $user = Auth::user();
        $measuring_device = MeasuringDevice::all();
        $area = Area::all();
        $carname = Carname::all();
        $freq = FreqCalMeasuringDevice::all();
        $selectedDeviceId = $request->session()->get('selectedDeviceId');

        if ($selectedDeviceId) {
            $selectedDevice = MeasuringDevice::find($selectedDeviceId);
            session(['selectedDevice' => $selectedDevice]);
        } else {
            session()->forget('selectedDevice');
        }

        return view('cal.index', compact('calibration', 'measuring_device', 'area', 'carname', 'user', 'freq'));
    }


    public function store(Request $request)
    {
        try {
            $rules = [
                'nik' => 'required|string',
                'shift' => 'required|string',
                'measuring_device_id' => 'required|exists:measuring_devices,id',
                'con_before_cal' => 'required|string',
                'con_after_cal' => 'required|string',
                'cal_date' => 'required|date',
                'no_certificate' => 'required|string',
                'result' => 'required|string',
                'area_id' => 'required|exists:areas,id',
                'carname_id' => 'required|exists:carnames,id',
                'cal_supplier' => 'required|string',

            ];

            // Conditionally add validation rules for section 2
            if ($request->result == 'N-OK') {
                $rules = array_merge($rules, [
                    'service_place' => 'required|string',
                    'start_ser_date' => 'required|date',
                    'finish_ser_date' => 'required|date',
                    'problem' => 'string',
                    'next_action' => 'string',
                ]);
            }

            // Perform validation
            $request->validate($rules);

            $measuringDevice = MeasuringDevice::findOrFail($request->measuring_device_id);
            $folderName = strtolower(str_replace(' ', '_', $measuringDevice->no_control . '_' . $measuringDevice->device_name));
            $calibrationDate = date('dmY', strtotime($request->cal_date));

            // Check if the directory exists, create it if not
            $directory = "calibration/certificate/{$folderName}";

            if (!Storage::exists($directory)) {
                if (!Storage::makeDirectory($directory)) {
                    throw new \Exception('Failed to create directory');
                }
            }

            // Debugging: Check if the directory was created successfully
            if (!Storage::exists($directory)) {
                throw new \Exception('Directory not created');
            }

            $fileName1 = null;
            $fileName2 = null;

            if ($request->hasFile('file1')) {
                $request->validate([
                    'file1' => 'mimes:jpeg,png,jpg,gif,svg,pdf',
                ]);
                $file1 = $request->file('file1');
                $extension1 = $file1->getClientOriginalExtension();
                $fileName1 = time() . "_{$measuringDevice->no_control}_{$calibrationDate}_certificate_1.{$extension1}";
                if (!$file1->storeAs($directory, $fileName1, 'public')) {
                    throw new \Exception('Failed to store file1');
                }
            }

            if ($request->hasFile('file2')) {
                $request->validate([
                    'file1' => 'mimes:jpeg,png,jpg,gif,svg,pdf',
                ]);
                $file2 = $request->file('file2');
                $extension2 = $file2->getClientOriginalExtension();
                $fileName2 = time() . "_{$measuringDevice->no_control}_{$calibrationDate}_certificate_2.{$extension2}";
                if (!$file2->storeAs($directory, $fileName2, 'public')) {
                    throw new \Exception('Failed to store file2');
                }
            }

            // Create Calibration model and store data
            $calibration = Calibration::create([
                'nik' => $request->nik,
                'shift' => $request->shift,
                'measuring_device_id' => $request->measuring_device_id,
                'con_before_cal' => $request->con_before_cal,
                'con_after_cal' => $request->con_after_cal,
                'cal_date' => $request->cal_date,
                'no_certificate' => $request->no_certificate,
                'file1' => $fileName1 ? "{$directory}/{$fileName1}" : null,
                'file2' => $fileName2 ? "{$directory}/{$fileName2}" : null,
                'result' => $request->result,
                'area_id' => $request->area_id,
                'carname_id' => $request->carname_id,
                'cal_supplier' => $request->cal_supplier,
                'service_place' => $request->service_place,
                'start_ser_date' => $request->start_ser_date,
                'finish_ser_date' => $request->finish_ser_date,
                'problem' => $request->problem,
                'next_action' => $request->next_action,
            ]);

            // Redirect back with success message

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to add the Device')->withInput();
        }
    }

    public function edit($id)
    {
        // Fetch the calibration with its related measuring device
        $calibration = Calibration::with('measuringDevice.freq')->findOrFail($id);

        // Fetch other necessary data
        $measuring_device = MeasuringDevice::all();
        $freq = FreqCalMeasuringDevice::all();
        $area = Area::all();
        $carname = Carname::all();

        // Pass the calibration in an array format to the view
        return view('cal.edit', compact('measuring_device', 'calibration', 'area', 'carname', 'freq'));
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'nik' => 'required|string',
                'shift' => 'string',
                // 'measuring_device_id' => 'required|exists:measuring_devices,id',
                'con_before_cal' => 'required|string',
                'con_after_cal' => 'required|string',
                'cal_date' => 'date',
                'no_certificate' => 'string',
                // 'certificate' => 'required|string',
                'result' => 'required|in:OK,N-OK',
                'area_id' => 'exists:areas,id',
                'carname_id' => 'exists:carnames,id',
                'cal_supplier' => 'required|string',
            ]);

            $calibration = Calibration::findOrFail($id);

            if ($request->hasFile('certificate')) {
                $file = $request->file('certificate');
                $extension = $file->getClientOriginalExtension();
                $fileName = time() . "_{$calibration->id}_certificate.{$extension}";
                if (!$file->storeAs('path/ke/direktori/penyimpanan', $fileName)) {
                    throw new \Exception('Failed to store certificate file');
                }
                Storage::delete($calibration->certificate);
                $calibration->update(['certificate' => $fileName]);
            }

            $calibration->update($request->all());

            return redirect()->back()->with('success', 'Calibration successfully updated!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update Calibration.')->withInput();
        }
    }

    public function destroy($id)
    {
        //fungsi eloquent untuk menghapus data
        Calibration::find($id)->delete();
        return redirect()->back()->with('success', 'Calibration successfully deleted!');
    }


}
