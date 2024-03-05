<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Type;
use App\Models\Merk;
use App\Models\Range;
use App\Models\Resolution;
use App\Models\Area; // Add this line
use App\Models\Carname; // Add this line

class SubTableController extends Controller
{
    public function index()
    {
        // Fetch data for each table
        $types = Type::all();
        $merks = Merk::all();
        $ranges = Range::all();
        $resolutions = Resolution::all();
        $areas = Area::all(); // Fetch area data
        $carnames = Carname::all(); // Fetch car data

        // Pass data to the view
        return view('sub_table.index', compact('types', 'merks', 'ranges', 'resolutions', 'areas', 'carnames'));
    }
}
