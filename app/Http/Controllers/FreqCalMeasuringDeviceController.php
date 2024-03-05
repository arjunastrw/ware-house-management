<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Validation\Rule;
use App\Models\Area;

use App\Models\FreqCalMeasuringDevice;
use App\Http\Requests\StoreFreqCalMeasuringDeviceRequest;
use App\Http\Requests\UpdateFreqCalMeasuringDeviceRequest;
use Yajra\DataTables\Facades\DataTables;

class FreqCalMeasuringDeviceController extends Controller
{

    public function data()
    {
        $query = FreqCalMeasuringDevice::query();
        return DataTables::of($query)->toJson();
    }

    public function index()
    {
        // Fetch all FreqCalMeasuringDevices from the database
        $freqCals = FreqCalMeasuringDevice::orderBy('updated_at', 'desc')->get();
        $area = Area::all();

        // Return a view with the devices data
        return view('freq.index', compact('freqCals', 'area'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'device_name' => 'required|unique:freq_cal_measuring_devices',
                'cal_status' => 'required|in:Internal,External',
                'freq_cal_num' => 'required',
                'life_time_num' => 'required',
            ]);

            // Create a new user with the provided data and set the role
            $freq_cal_measuring_device = FreqCalMeasuringDevice::create([
                'device_name' => $request->device_name,
                'cal_status' => $request->cal_status,
                'freq_cal_num' => $request->freq_cal_num,
                'freq_cal_unit' => $request->freq_cal_unit,
                'life_time_num' => $request->life_time_num,
                'life_time_unit' => $request->life_time_unit,
            ]);

            // Redirect the user to a desired location after saving to the database
            return redirect()->back()->with('success', 'UploadMeasuringDevice successfully added!');
        } catch (\Exception $e) {
            $errorData = [];
            // Handle the error, you can log it or provide a specific error message

            $errorData = ['message' => 'Failed to add the Device'];
            $errorData['old_input'] = $request->all();

            // Use the showNotification function to display the error message
            return redirect()->back()->with('error', $errorData)->withInput();
        }
    }

    public function edit($id)
    {
        $freq_cal = FreqCalMeasuringDevice::findOrFail($id);
        return view('freq.edit', compact('freq_cal'));
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'device_name' => ['required', Rule::unique('freq_cal_measuring_devices')->ignore($id)],
                'cal_status' => 'required|in:Internal,External',
                'freq_cal_num' => 'required',
                'life_time_num' => 'required',
            ]);

            $freq_cal_measuring_device = FreqCalMeasuringDevice::findOrFail($id);

            // Update the attributes
            $freq_cal_measuring_device->update($request->all());

            return redirect()->back()->with('success', 'UploadMeasuringDevice successfully updated!');
        } catch (\Exception $e) {
            // Handle the error and provide feedback to the user
            $errorData = [];
            dd($e->getMessage());
            if ($e instanceof \Illuminate\Database\QueryException && $e->getCode() === '23000') {
                $errorData = ['message' => 'The provided data already exists.'];
            } else {
                $errorData = ['message' => 'Failed to update UploadMeasuringDevice. Please try again.'];
            }

            if ($e instanceof \Illuminate\Validation\ValidationException) {
                $errorData['validation_errors'] = $e->validator->errors()->toArray();
                $errorData['old_input'] = $request->all();
            }

            return redirect()->back()->with('error', $errorData)->withInput();
        }
    }

    public function destroy($id)
    {
//        //fungsi eloquent untuk menghapus data
//        FreqCalMeasuringDevice::find($id)->delete();
//        return redirect()->back()->with('success', 'Measuring Device Successfully Deleted!');


        $measuringDeviceIds = MeasuringDevice::where('freq_cal_measuring_device_id', $id)->pluck('id');

        Calibration::whereIn('measuring_device_id', $measuringDeviceIds)->delete();

        MeasuringDevice::whereIn('id', $measuringDeviceIds)->delete();

        FreqCalMeasuringDevice::destroy($id);

        return redirect()->back()->with('success', 'Frequency Calibration, Measuring Devices, and related calibrations deleted successfully');

    }
}
