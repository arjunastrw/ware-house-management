<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Models\Type;
use App\Http\Requests\StoreTypeRequest;
use App\Http\Requests\UpdateTypeRequest;

class TypeController extends Controller
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
    public function store(Request $request)
    {
        try {
            $request->validate([
                'type' => 'required|string|max:255|unique:types',
            ]);

            // Create a new user with the provided data and set the role
            $type = Type::create([
                'type' => $request->type,
            ]);

            // Redirect the user to a desired location after saving to the database
            return redirect()->back()->with('measuring_success', 'Type successfully added!');
        } catch (\Exception $e) {
            $errorData = [];

            // Handle the error, you can log it or provide a specific error message
            $errorData = ['message' => 'Failed to add the Type'];
            $errorData['old_input'] = $request->all();

            // Use the showNotification function to display the error message
            return redirect()->back()->with('measuring_error', $errorData)->withInput();
        }
    }

    public function edit($id)
    {
        $types = Type::findOrFail($id);

        return view('sub_table.edit', compact('types'));
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'type' => 'required|string|max:255|unique:types,type,' . $id,
            ]);

            $type = Type::findOrFail($id);

            // Update the attributes
            $type->update($request->all());

            return redirect()->back()->with('measuring_success', 'Type successfully updated!');
        } catch (\Exception $e) {
            // Handle the error and provide feedback to the user
            $errorData = [];

            if ($e instanceof \Illuminate\Database\QueryException && $e->getCode() === '23000') {
                // Unique constraint violation
                $errorData = ['message' => 'The provided Type value is already in use. Please put a different one.'];
            } else {
                // Other database or validation error
                $errorData = ['message' => 'Failed to update Type. Please try again.'];
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
        Type::find($id)->delete();
        return redirect()->back()->with('measuring_success', 'Type Successfully Deleted!');
    }
}
