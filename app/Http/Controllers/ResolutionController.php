<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Models\Resolution;
use App\Http\Requests\StoreResolutionRequest;
use App\Http\Requests\UpdateResolutionRequest;

class ResolutionController extends Controller
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
        try {
            $request->validate([
                'resolution' => 'required|string|max:255|unique:resolutions',
            ]);

            // Create a new user with the provided data and set the role
            $resolution = Resolution::create([
                'resolution' => $request->resolution,
            ]);

            // Redirect the user to a desired location after saving to the database
            return redirect()->back()->with('measuring_success', 'Resolution successfully added!');
        } catch (\Exception $e) {
            $errorData = [];

            // Handle the error, you can log it or provide a specific error message
            $errorData = ['message' => 'Failed to add the Resolution'];
            $errorData['old_input'] = $request->all();

            // Use the showNotification function to display the error message
            return redirect()->back()->with('measuring_error', $errorData)->withInput();
        }
    }

    public function edit($id)
    {
        $resolutions = Resolution::findOrFail($id);

        return view('sub_table.edit', compact('resolutions'));
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'resolution' => 'required|string|max:255|unique:resolutions,resolution,' . $id,
            ]);

            $resolution = Resolution::findOrFail($id);

            // Update the attributes
            $resolution->update($request->all());

            return redirect()->back()->with('measuring_success', 'Resolution successfully updated!');
        } catch (\Exception $e) {
            // Handle the error and provide feedback to the user
            $errorData = [];

            if ($e instanceof \Illuminate\Database\QueryException && $e->getCode() === '23000') {
                // Unique constraint violation
                $errorData = ['message' => 'The provided Resolution value is already in use. Please put a different one.'];
            } else {
                // Other database or validation error
                $errorData = ['message' => 'Failed to update Resolution. Please try again.'];
            }

            if ($e instanceof \Illuminate\Validation\ValidationException) {
                $errorData['validation_errors'] = $e->validator->errors()->toArray();
                $errorData['old_input'] = $request->all();
            }

            return redirect()->back()->with('measuring_error', $errorData)->withInput();
        }
    }


    public function destroy($id)
    {
        //fungsi eloquent untuk menghapus data
        Resolution::find($id)->delete();
        return redirect()->back()->with('measuring_success', 'Resolution Successfully Deleted Dihapus!');
    }
}
