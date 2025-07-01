<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Purchase_item;
use App\Models\Stock;
use App\Models\Supplier;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class purchaseController extends Controller
{

        function purchase(Request $request) {
            $search = $request->input('search');
            if (!empty($search)) {
                $purchase = Purchase::with(['supplier'])->whereHas('supplier', function ($query) use ($search) {
                    $query->where('supplier_name', 'LIKE', "%$search%");})->get();
                $purchase_item = Purchase_item::with(['category' , 'category' , 'product']);
            }else{
                $purchase = Purchase::with(['supplier', 'purchase'])->get();
                $purchase_item = Purchase_item::with(['category' , 'category' , 'product']);
            }
        return view("purchase" , ['purchase' => $purchase , 'purchase_item' => $purchase_item]);
    }


    function add_purchase() {
        // supplier
        $suppliers = Supplier::select('id', 'supplier_name')->get();
        // category
        $categories = Category::select('category', 'id')->get();
        // product
        $product = Product::select('product_name', 'id')->get();
        return view("add_purchase" , ['suppliers' => $suppliers  , 'categories' => $categories , 'products' => $product ]);
    }

    function store(Request $request) {

    $validator = Validator::make($request->all(), [
        'supplier'       => 'required',
        'total_all'      => 'required|numeric|min:0',
        'description'    => 'nullable|string|max:255',
        'category'       => 'required|array|min:1',
        'category.*'     => 'required',
        'product'        => 'required|array|min:1',
        'product.*'      => 'required',
        'quantity'       => 'required|array|min:1',
        'quantity.*'     => 'required|numeric|min:1',
        'price'          => 'required|array|min:1',
        'price.*'        => 'required|numeric|min:0',
        'total'          => 'required|array|min:1',
        'total.*'        => 'required|numeric|min:0',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

        DB::beginTransaction();
        try {
            $purchase = Purchase::create([
            'supplier_id' => $request->supplier,
            'total_amount' => $request->total_all,
            'status' => '0',
            'description' => $request->description,
        ]);
        // insert
    foreach ($request->category as $index => $category) {
    $stock = Stock::where('product_id', $request->product[$index])->first();

    if ($stock) {
        $stock->in_qty += $request->quantity[$index];
        $stock->save();
    Transaction::create([
    'type' => 'in',
    'product_id' => $request->product[$index],
    'qty' => $request->quantity[$index],
]);
    } else {
    Transaction::create([
    'type' => 'in',
    'product_id' => $request->product[$index],
    'qty' => $request->quantity[$index],
]);
    Stock::create([
        'supplier_id' => $request->supplier,
        'category_id' => $category,
        'product_id'  => $request->product[$index],
        'in_qty'       => $request->quantity[$index],
    ]);

    }
    Purchase_item::create([
        'purchase_id' => $purchase->id,
        'category_id' => $category,
        'product_id' => $request->product[$index],
        'quantity' => $request->quantity[$index],
        'unit_price' => $request->price[$index],
        'total_price' => $request->total[$index],
    ]);
    }
    DB::commit();
    return redirect()->route('purchase')->with('success', 'Purchase Added Successfully');
    } catch (\Exception $e) {
    DB::rollBack(); 
    return response()->json(['error' => $e->getMessage()], 500);
    }
    }

    function destroy($id) {
        Product::destroy($id);
    return redirect()->route('purchase')->with('success', 'Product Deleted Successfully'); 
    }

    function view($id) {
        $purchase = Purchase::with('supplier')->where('id', $id)->get();
        $purchase_item = Purchase_item::with('category','product')->where('purchase_id', $id)->get();
        return view('purchase_view', ['purchases' => $purchase , 'purchase_item' => $purchase_item]);
    }
    
    
    
    function edit(Purchase $purchase) {
        // supplier
        $suppliers = Supplier::select('id', 'supplier_name')->get();
        // category
        $categories = Category::select('category', 'id')->get();
        // product
        $product = Product::select('product_name', 'id')->get();
        // product_items
        $purchase_item = Purchase_item::with('category','product')->where('purchase_id', $purchase->id)->get();
        return view('purchase_edit', ['purchase' => $purchase ,'suppliers' => $suppliers  , 'categories' => $categories , 'products' => $product ,  'purchase_item' => $purchase_item]);
    }



public function update(Request $request, $id)
{
    $request->validate([
        'supplier' => 'required|numeric',
        'description' => 'nullable|string',
        'category' => 'required|array',
        'product' => 'required|array',
        'quantity' => 'required|array',
        'price' => 'required|array',
        'total' => 'required|array',
        'total_all' => 'required|numeric',
    ]);

    $purchase = Purchase::findOrFail($id);

    $purchase->update([
        'supplier_id' => $request->supplier,
        'description' => $request->description,
        'total_amount' => $request->total_all,
        'status' => 0,
    ]);

    $oldItems = Purchase_item::where('purchase_id', $id)->get();
    $oldCount = $oldItems->count();
    $newCount = count($request->product);

    for ($i = 0; $i < max($oldCount, $newCount); $i++) {

        if ($i < $newCount && $i < $oldCount) {

            $oldItem = $oldItems[$i];
            $oldProductId = $oldItem->product_id;
            $oldQty = $oldItem->quantity;
            $newProductId = $request->product[$i];
            $newQty = $request->quantity[$i];

            $oldStock = Stock::where('product_id', $oldProductId)->first();
            if ($oldStock) {
                $oldStock->in_qty -= $oldQty;
                $oldStock->save();
            }

            $newStock = Stock::where('product_id', $newProductId)->first();
            if ($newStock) {
                $newStock->in_qty += $newQty;
                $newStock->save();
            }

            $oldItem->update([
                'category_id' => $request->category[$i],
                'product_id' => $newProductId,
                'quantity' => $newQty,
                'unit_price' => $request->price[$i],
                'total_price' => $request->total[$i],
            ]);

        } elseif ($i >= $oldCount && $i < $newCount) {
            $productId = $request->product[$i];
            $qty = $request->quantity[$i];

            $stock = Stock::where('product_id', $productId)->first();
            if ($stock) {
                $stock->in_qty += $qty;
                $stock->save();
            }

            Purchase_item::create([
                'purchase_id' => $purchase->id,
                'product_id' => $productId,
                'category_id' => $request->category[$i],
                'quantity' => $qty,
                'unit_price' => $request->price[$i],
                'total_price' => $request->total[$i],
            ]);

        } elseif ($i >= $newCount && $i < $oldCount) {
            $oldItem = $oldItems[$i];
            $stock = Stock::where('product_id', $oldItem->product_id)->first();
            if ($stock) {
                $stock->in_qty -= $oldItem->quantity;
                $stock->save();
            }
            $oldItem->delete();
        }
    }

    return redirect()->route('purchase')->with('success', 'Purchase updated successfully');
}


    function status($id) {
        $status = Purchase::findOrFail($id);
        $status->status = 1;
        $status->save();
        return redirect()->route('purchase')->with('success', 'Purchase status updated successfully.');
    }

}




