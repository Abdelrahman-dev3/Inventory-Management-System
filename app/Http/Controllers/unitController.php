<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;

class unitController extends Controller
{
    function unit(Request $request) {
            $search = $request->input('search');
            if (!empty($search)) {
                $units = Unit::where('unit_name', 'LIKE', "%$search%")->get();
            }else{
                $units = Unit::all();
            }
        return view("unit" , ['units' => $units]);
    }

        function add_unit() {
        return view("add_unit");
    }

        function store(Request $request) {
        // validition
        $request->validate([
            'unit_name' => 'required|unique:units,unit_name',
        ]);
        // insert
        Unit::create([
        'unit_name' => $request->unit_name,
    ]);

    return redirect()->route('unit')->with('success', 'Unit Added Successfully');

    }

    function destroy($id) {
        Unit::destroy($id);
    return redirect()->route('unit')->with('success', 'Unit Deleted Successfully'); 
    }
}
