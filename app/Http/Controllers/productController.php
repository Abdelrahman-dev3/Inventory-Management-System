<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Unit;
use Illuminate\Http\Request;

class productController extends Controller
{
    function product(Request $request) {

            $search = $request->input('search');
            if (!empty($search)) {
                $products = Product::with(['supplier', 'category', 'unit'])->where('product_name', 'LIKE', "%$search%")->get();
            }else{
                $products = Product::with(['supplier', 'category', 'unit'])->get();
            }
        return view("product" , ['products' => $products]);
    }

    function add_product() {
        // supplier
        $suppliers = Supplier::select('id', 'supplier_name')->get();
        // unit
        $units = Unit::select('unit_name', 'id')->get();
        // category
        $categories = Category::select('category', 'id')->get();

        return view("add_product" , [ 'suppliers' => $suppliers , 'units' => $units , 'categories' => $categories]);
    }

    function store(Request $request) {
        // validition
        $request->validate([
            'product_name' => 'required',
            'supplier' => 'required|exists:suppliers,id',
            'unit' => 'required|exists:units,id',
            'category' => 'required|exists:categories,id',
        ]);
        // insert
        Product::create([
        'product_name' => $request->product_name,
        'supplier_id' => $request->supplier,
        'unit_id' => $request->unit,
        'category_id' => $request->category,
    ]);
    return redirect()->route('product')->with('success', 'Product Added Successfully');
    }

    
    function destroy($id) {
        Product::destroy($id);
    return redirect()->route('product')->with('success', 'Product Deleted Successfully'); 
    }

    function edit(Product $product) {
        // supplier
        $suppliers = Supplier::select('id', 'supplier_name')->get();
        // unit
        $units = Unit::select('unit_name', 'id')->get();
        // category
        $categories = Category::select('category', 'id')->get();

    return view('edit_product' , [ 'suppliers' => $suppliers , 'units' => $units , 'categories' => $categories , 'product' => $product]); 
    }


        function update(Request $request) {
        $request->validate([
            'product_name' => 'required',
            'supplier' => 'required',
            'unit' => 'required',
            'category' => 'required',
        ]);
        
        $product = Product::find($request->id);
        
        $product->update([
            'product_name' => $request->product_name ,
            'supplier_id' => $request->supplier ,
            'unit_id' => $request->unit ,
            'category_id' => $request->category ,
        ]);
        return redirect()->route('product')->with('success', 'Product Updated Successfully'); 
    }

}
