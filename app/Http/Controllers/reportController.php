<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Stock;
use App\Models\Supplier;
use Illuminate\Http\Request;

class reportController extends Controller
{
    function report(){
        // supplier
        $suppliers = Supplier::select('id', 'supplier_name')->get();
        // category
        $categories = Category::select('category', 'id')->get();
        // product
        $products = Product::select('product_name', 'id')->get();
        $stocks = Stock::with(['category','product','supplier'])->get();
        return view("report" , [ 'products' => $products , 'stocks' => $stocks, 'suppliers' => $suppliers , 'categories' => $categories]);
    }

        function update(Request $request) {
        $request->validate([
            'supplier' => 'required|array',
            'supplier.*' => 'required|integer',
            'category' => 'required|array',
            'category.*' => 'required|integer',
            'product'  => 'required|array',
            'product.*' => 'required|integer',
            'quantity' => 'required|array',
            'quantity.*' => 'required|numeric|min:1',
        ]);
        $errors = [];
        foreach ($request->supplier as $index => $supplier_id) {
            $category_id = $request->category[$index];
            $product_id  = $request->product[$index];
            $quantity    = $request->quantity[$index];
            
        $productName  = Product::find($product_id)?->product_name ?? 'Unknown';
        $supplierName = Supplier::find($supplier_id)?->supplier_name ?? 'Unknown';
        $categoryName = Category::find($category_id)?->category ?? 'Unknown';
            
        $stock = Stock::where('supplier_id', $supplier_id)->where('category_id', $category_id)->where('product_id', $product_id)->first();

        if ($stock) {
            $stock->in_qty += $quantity;
            $stock->save();
            return to_route('report');
        } else {
            $errors[] = "The selected product ($productName) for supplier $supplierName and category $categoryName does not exist.";
        }
    }
        if (!empty($errors)) {
        return back()->withErrors($errors)->withInput();
    }
    }
}

