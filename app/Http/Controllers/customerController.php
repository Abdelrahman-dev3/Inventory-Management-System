<?php

namespace App\Http\Controllers;
use App\Models\Customers;
use App\Models\Inovice;
use App\Models\Inovice_items;
use Illuminate\Http\Request;

use function Ramsey\Uuid\v1;

class customerController extends Controller
{









        function customer(Request $request) {
            $search = $request->input('search');
            if (!empty($search)) {
                $customers = Customers::where('customer_name', 'LIKE', "%$search%")->get();
            }else{
                $customers = Customers::all();
            }
        return view("customer" , ['customers' => $customers]);
    }












    function add_customer() {
        return view("add_customer");
    }

        function store(Request $request) {
        // validition
        $request->validate([
            'customer_name' => 'required',
            'customer_image' => 'file',
            'email' => 'required|email|unique:customers,email',
            'address' => 'required',
        ]);
        $filename='';
        if ($request->hasFile('customer_image')) {
            $file = $request->file('customer_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/customers'), $filename);
        }
        // insert
        Customers::create([
        'customer_name' => $request->customer_name,
        'customer_image' => $filename,
        'email' => $request->email,
        'address' => $request->address,
    ]);

    return redirect()->route('customer')->with('success', 'Customer Added Successfully');

    }

    function destroy($id) {
        Customers::destroy($id);
    return redirect()->route('customer')->with('success', 'Customers Deleted Successfully'); 
    }

    function edit(Customers $customer) {
        return view('edit_customer' , ['customer' => $customer]);
    }

    function update(Request $request) {
        $request->validate([
            'customer_name' => 'required',
            'customer_image' => 'file|mimes:jpg,jpeg,png|max:2048',
            'email' => 'email',
        ]);
        
        $customer = Customers::find($request->id);
        $filename = $customer->customer_image;
        
        if ($request->hasFile('customer_image')) {
        $file = $request->file('customer_image');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/customers'), $filename);
        }
        
        $customer->update([
            'customer_name' => $request->customer_name ,
            'customer_image' => $filename ,
            'email' => $request->email ,
            'address' => $request->address ,
        ]);
        return redirect()->route('customer')->with('success', 'Customers Updated Successfully'); 
    }

    function view($id) {
        $invoices_1 = Inovice::with('customer')->where('customer_id', $id)->first();

        if (!empty($invoices_1)) {
        $invoices = Inovice::with('customer')->where('customer_id', $id)->get();
        foreach ($invoices as $invoice) {
            $invoices_items = Inovice_items::with('product' , 'category')->where('invoice_No', $invoice->id)->get();
        };
        
        return view('view_customer' , ['invoices' => $invoices , 'invoices_items' => $invoices_items]);
        } else {
        return view('view_customer_no_invoice');
        }
        

    }


}