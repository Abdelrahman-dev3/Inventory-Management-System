<?php

namespace App\Http\Controllers;
use App\Models\Supplier;

use Illuminate\Http\Request;

class supplierController extends Controller
{
    function supplier(Request $request) {
            $search = $request->input('search');
            if (!empty($search)) {
                $suppliers = Supplier::where('supplier_name', 'LIKE', "%$search%")->get();
            }else{
                $suppliers = Supplier::all();
            }
        return view("supplier" , ['suppliers' => $suppliers]);
    }
    
    function add_supplier() {
        return view("add_supplier");
    }

        function store(Request $request) {
        // validition
        $request->validate([
            'supplier_name' => 'required',
            'supplier_mobile' => 'required|numeric',
            'supplier_email' => 'required|email|unique:suppliers,supplier_email',
        ]);
        // insert
        Supplier::create([
        'supplier_name' => $request->supplier_name,
        'supplier_mobile' => $request->supplier_mobile,
        'supplier_email' => $request->supplier_email,
        'supplier_address' => $request->supplier_address,
    ]);
    return redirect()->route('supplier')->with('success', 'Supplier Added Successfully');
    }


    function destroy($id) {
        Supplier::destroy($id);
    return redirect()->route('supplier')->with('success', 'Supplier Deleted Successfully'); 
    }

    function edit(Supplier $supplier) {
        return view('edit_supplier' , ['supplier' => $supplier]); 
    }

    function update(Request $request) {
        // validition
        $request->validate([
            'supplier_name' => 'required',
            'supplier_mobile' => 'required|numeric',
            'supplier_email' => 'required|email',
        ]);
        // update
        $supplier = Supplier::find($request->id);
        $supplier->update([
        'supplier_name' => $request->supplier_name,
        'supplier_mobile' => $request->supplier_mobile,
        'supplier_email' => $request->supplier_email,
        'supplier_address' => $request->supplier_address,
    ]);
    return redirect()->route('supplier')->with('success', 'Supplier Updated Successfully'); 
    }
} 
