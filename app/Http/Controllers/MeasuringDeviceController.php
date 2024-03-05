<?php

namespace App\Http\Controllers;

use App\Models\MeasuringDevice;
use App\Models\Type;
use App\Models\Range;
use App\Models\Resolution;
use App\Models\Merk;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Models\FreqCalMeasuringDevice;
use Yajra\DataTables\Facades\DataTables;


class MeasuringDeviceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /**
     * Display a listing of the users.
     *
     * @param \App\Models\User $model
     * @return \Illuminate\View\View
     */
//    public function data()
//    {
//        $query = MeasuringDevice::with('freq', 'type', 'range', 'resolution', 'merk');
//        return DataTables::of($query)->toJson();
//    }
    public function data()
    {
        $query = MeasuringDevice::with('freq', 'type', 'range', 'resolution', 'merk');
        return DataTables::of($query)->toJson();
    }




//    public function data()
//    {
//        $query = MeasuringDevice::with('freq', 'type', 'range', 'resolution', 'merk');
//
//        return DataTables::of($query)
//            ->addColumn('action', function ($measuringDevice) {
//                return '<button type="button" class="btn btn-success btn-icon btn-sm editBtn" data-id="' . $measuringDevice->id . '" data-target="#editMeasuringDevice{{ $value -> id }}}' . $measuringDevice->id . '"><i class="fas fa-pencil-alt"></i></button>' .
//                    '<button type="button" class="btn btn-danger btn-icon btn-sm deleteBtn" data-toggle="modal" data-target="#deleteMeasuringDevice' . $measuringDevice->id . '"><i class="fas fa-trash-alt"></i></button>';
//            })
//            ->toJson();
//    }

    public function index(Request $request)
    {
        // Sorting
        $sortField = $request->input('sortField', 'measuring_devices.id');
        $sortOrder = $request->input('sortOrder', 'asc');

        // Load additional data for dropdowns or filters
        $freqs = FreqCalMeasuringDevice::all();
        $types = Type::all();
        $ranges = Range::all();
        $resolutions = Resolution::all();
        $merks = Merk::all();
        $measuring_device = MeasuringDevice::all();

        // Mengembalikan view dengan data yang diperlukan
        return view('measuring_device.index', compact('sortField', 'sortOrder', 'freqs', 'merks', 'types', 'ranges', 'resolutions', 'measuring_device'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */


    /**
     * Display the specified resource.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'no_control' => 'required|string|max:255|unique:measuring_devices',
                'freq_cal_measuring_device_id' => 'required|exists:freq_cal_measuring_devices,id',
                'type_id' => 'required|exists:types,id',
                'merk_id' => 'required|exists:merks,id',
                'no_seri' => 'required|string|max:255',
                'range_id' => 'required|exists:ranges,id',
                'resolution_id' => 'required|exists:resolutions,id',
                'ata_sai' => 'required|date',
                'inv_no' => 'required|string|max:255',
                'no_doc_bc' => 'required|string|max:255'
            ]);

            // Create a new user with the provided data and set the role
            $measuring_device = MeasuringDevice::create([
                'no_control' => $request->no_control,
                'freq_cal_measuring_device_id' => $request->freq_cal_measuring_device_id,
                'type_id' => $request->type_id,
                'merk_id' => $request->merk_id,
                'no_seri' => $request->no_seri,
                'range_id' => $request->range_id,
                'resolution_id' => $request->resolution_id,
                'ata_sai' => $request->ata_sai,
                'inv_no' => $request->inv_no,
                'no_doc_bc' => $request->no_doc_bc
            ]);

            // Redirect the user to a desired location after saving to the database

            return redirect()->back()->with('success', 'Measuring Device successfully added!');
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
        $freqs = FreqCalMeasuringDevice::all();
        $types = Type::all();
        $ranges = Range::all();
        $resolutions = Resolution::all();
        $merks = Merk::all();
        $measuring_device = MeasuringDevice::findOrFail($id);

        return view('measuring_device.edit', compact('measuring_device', 'freqs', 'types', 'ranges', 'resolutions', 'merks'));
    }

    public function update(Request $request, $id)
    {

        try {
            $request->validate([
                'no_control' => ['required', Rule::unique('measuring_devices')->ignore($id)],
                'freq_cal_measuring_device_id' => 'required|exists:freq_cal_measuring_devices,id',
                'type_id' => 'exists:types,id',
                'merk_id' => 'exists:merks,id',
                'no_seri' => 'string|max:255',
                'range_id' => 'exists:ranges,id',
                'resolution_id' => 'exists:resolutions,id',
                'ata_sai' => 'date',
                'inv_no' => 'string|max:255',
                'no_doc_bc' => 'string|max:255',
            ]);

            // Exclude _token and _method from the update data

            $measuring_device = MeasuringDevice::findOrFail($id);

            // Update the attributes
            $measuring_device->update([
                'no_control' => $request->input('no_control'),
                'freq_cal_measuring_device_id' => $request->input('freq_cal_measuring_device_id'),
                'type_id' => $request->input('type_id'),
                // ... other attributes ...
            ]);
            return redirect()->back()->with('success', 'Measuring Device successfully updated!');
        } catch (\Exception $e) {
            // Handle the error and provide feedback to the user
            $errorData = [];

            if ($e instanceof \Illuminate\Database\QueryException && $e->getCode() === '23000') {
                // Unique constraint violation
                $errorData = ['message' => 'The provided No Control value is already in use. Please choose a different one.'];
            } else {
                // Other database or validation error
                $errorData = ['message' => 'Failed to update Measuring Device. Please try again.'];
            }

            if ($e instanceof \Illuminate\Validation\ValidationException) {
                $errorData['validation_errors'] = $e->validator->errors()->toArray();
                $errorData['old_input'] = $request->all();
            }

            return redirect()->back()->with('error', $errorData)->withInput();
        }
    }

    public function getDeviceName(Request $request, $id)
    {
        try {

            $device = MeasuringDevice::findOrFail($id);
            $deviceName = $device->freq->device_name;

            return response()->json(['device_name' => $deviceName]);
        } catch (\Exception $e) {
            dd($e->getMessage());
            return response()->json(['error' => 'Device not found'], 404);
        }
    }

    public function destroy($id)
    {
//        //fungsi eloquent untuk menghapus data
//        MeasuringDevice::find($id)->delete();
//        return redirect()->back()->with('success', 'Measuring Device Successfully Deleted!');
        Calibration::where('measuring_device_id', $id)->delete();

        // Hapus perangkat pengukur itu sendiri
        MeasuringDevice::destroy($id);

        return redirect()->back()->with('success', 'Measuring Device and related calibrations deleted successfully');

    }

}
