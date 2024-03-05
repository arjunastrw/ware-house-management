<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;


use App\Models\Range;
use App\Http\Requests\StoreRangeRequest;
use App\Http\Requests\UpdateRangeRequest;

class RangeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(Request $request)
    {
        try {
            $request->validate([
                'range' => 'required|string|max:255|unique:ranges',
            ]);

            // Create a new user with the provided data and set the role
            $range = Range::create([
                'range' => $request->range,
            ]);

            // Redirect the user to a desired location after saving to the database
            return redirect()->back()->with('measuring_success', 'Range successfully added!');
        } catch (\Exception $e) {
            $errorData = [];

            // Handle the error, you can log it or provide a specific error message
            $errorData = ['message' => 'Failed to add the Range'];
            $errorData['old_input'] = $request->all();

            // Use the showNotification function to display the error message
            return redirect()->back()->with('measuring_error', $errorData)->withInput();
        }
    }

    public function edit($id)
    {
        $ranges = Range::findOrFail($id);

        return view('sub_table.edit', compact('ranges'));
    }

    public function update(Request $request, $id)
    {
        
        try {
            $request->validate([
                'range' => 'required|string|max:255|unique:ranges,range,' . $id,
            ]);

            $range = Range::findOrFail($id);

            // Update the attributes
            $range->update($request->all());

            return redirect()->back()->with('measuring_success', 'Range successfully updated!');
        } catch (\Exception $e) {
            // Handle the error and provide feedback to the user
            $errorData = [];

            if ($e instanceof \Illuminate\Database\QueryException && $e->getCode() === '23000') {
                // Unique constraint violation
                $errorData = ['message' => 'The provided Range value is already in use. Please put a different one.'];
            } else {
                // Other database or validation error
                $errorData = ['message' => 'Failed to update Range. Please try again.'];
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
        Range::find($id)->delete();
        return redirect()->back()->with('measuring_success', 'Range Successfully Deleted Dihapus!');
    }
}
