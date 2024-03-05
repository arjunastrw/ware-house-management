<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Models\Area;
use App\Http\Requests\StoreAreaRequest;
use App\Http\Requests\UpdateAreaRequest;

class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function store(Request $request)
    {
        $activeTab = $request->input('active_tab', 'calSection');

        try {
            $request->validate([
                'area' => 'required|string|max:255|unique:areas',
            ]);

            // Create a new user with the provided data and set the role
            $area = Area::create([
                'area' => $request->area,
            ]);

            // Redirect the user to a desired location after saving to the database
            return redirect()->back()->with('success', 'Area successfully added!')->with('active_tab', $activeTab);
        } catch (\Exception $e) {
            $errorData = [];

            // Handle the error, you can log it or provide a specific error message
            $errorData = ['message' => 'Failed to add the Area'];
            $errorData['old_input'] = $request->all();

            // Use the showNotification function to display the error message
            return redirect()->back()->with('error', $errorData)->withInput()->with('active_tab', $activeTab);
        }
    }

    public function edit($id)
    {
        $areas = Area::findOrFail($id);

        return view('sub_table.edit', compact('areas'));
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'area' => 'required|string|max:255|unique:areas,area,' . $id,
            ]);

            $area = Area::findOrFail($id);

            // Update the attributes
            $area->update($request->all());

            return redirect()->back()->with('success', 'Area successfully updated!');
        } catch (\Exception $e) {
            // Handle the error and provide feedback to the user
            $errorData = [];

            if ($e instanceof \Illuminate\Database\QueryException && $e->getCode() === '23000') {
                // Unique constraint violation
                $errorData = ['message' => 'The provided Area value is already in use. Please put a different one.'];
            } else {
                // Other database or validation error
                $errorData = ['message' => 'Failed to update Area. Please try again.'];
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
        //fungsi eloquent untuk menghapus data
        Area::find($id)->delete();
        return redirect()->back()->with('success', 'Area Successfully Deleted!');
    }
}
