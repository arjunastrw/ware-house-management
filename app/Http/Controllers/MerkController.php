<?php

namespace App\Http\Controllers;

use App\Models\Merk;
use Illuminate\Http\Request;

use App\Http\Requests\StoreMerkRequest;
use App\Http\Requests\UpdateMerkRequest;

class MerkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

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
                'merk' => 'required|string|max:255|unique:merks',
            ]);

            // Create a new user with the provided data and set the role
            $merk = Merk::create([
                'merk' => $request->merk,
            ]);

            // Redirect the user to a desired location after saving to the database
            return redirect()->back()->with('measuring_success', 'Merk successfully added!');
        } catch (\Exception $e) {
            $errorData = [];

            // Handle the error, you can log it or provide a specific error message
            $errorData = ['message' => 'Failed to add the Merk'];
            $errorData['old_input'] = $request->all();

            // Use the showNotification function to display the error message
            return redirect()->back()->with('measuring_error', $errorData)->withInput();
        }
    }

    public function edit($id)
    {
        $merks = Merk::findOrFail($id);

        return view('sub_table.edit', compact('merks'));
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'merk' => 'required|string|max:255|unique:merks,merk,' . $id,
            ]);

            $merk = Merk::findOrFail($id);

            // Update the attributes
            $merk->update($request->all());

            return redirect()->back()->with('measuring_success', 'Merk successfully updated!');
        } catch (\Exception $e) {
            // Handle the error and provide feedback to the user
            $errorData = [];

            if ($e instanceof \Illuminate\Database\QueryException && $e->getCode() === '23000') {
                // Unique constraint violation
                $errorData = ['message' => 'The provided Merk value is already in use. Please put a different one.'];
            } else {
                // Other database or validation error
                $errorData = ['message' => 'Failed to update Merk. Please try again.'];
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
        Merk::find($id)->delete();
        return redirect()->back()->with('measuring_success', 'Merk Successfully Deleted!');
    }
}
