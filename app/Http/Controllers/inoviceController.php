<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Models\Category;
use App\Models\Customers;
use App\Models\Inovice;
use App\Models\Inovice_items;
use App\Models\Product;
use App\Models\Purchase_item;
use App\Models\Stock;
use App\Models\Supplier;
use App\Models\Transaction;
use Illuminate\Http\Request;

class inoviceController extends Controller
{
    function inovice(Request $request) {
            $search = $request->input('search');
            if (!empty($search)) {
                $inovice = Inovice::with(['customer'])->whereHas('customer', function ($query) use ($search) {
                    $query->where('customer_name', 'LIKE', "%$search%");})->get();
            }else{
                $inovice = Inovice::with(['customer'])->get();
            }
        return view("inovice" , ['inovices' => $inovice]);
    }

    function add_inovice() {
        // customer
        $customers = Customers::select('id', 'customer_name')->get();
        // category
        $categories = Category::select('category', 'id')->get();
        // product
        $product = Product::select('product_name', 'id')->get();
        return view("add_inovice" , [ 'customers' => $customers , 'categories' => $categories , 'products' => $product]);
    }

    function store(Request $request) {
        // validition
            $validator = Validator::make($request->all(), [
        'customer'               => 'required',
        'description'            => 'nullable|string|max:255',
        'total_before_discount'  => 'required|numeric|min:0',
        'discount'               => 'nullable|numeric|min:0',
        'total_after_discount'   => 'required|numeric|min:0',
        'paid_Status'            => 'required',
        'category'               => 'required|array|min:1',
        'category.*'             => 'required',
        'product'                => 'required|array|min:1',
        'product.*'              => 'required',
        'quantity'               => 'required|array|min:1',
        'quantity.*'             => 'required|numeric|min:1',
        'price'                  => 'required|array|min:1',
        'price.*'                => 'required|numeric|min:0',
        'total'                  => 'required|array|min:1',
        'total.*'                => 'required|numeric|min:0',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }
        foreach ($request->product as $index => $product_id) {
            $quantity = $request->quantity[$index];
            $product =  Product::find($product_id);
            $stock = Stock::where('product_id', $product_id)->first();
            if (!$stock) {
                return redirect()->back()->with('error', "The Product Name:$product->product_name Is Not Found In Stock");
            }
            if ( ($stock->in_qty - $stock->out_qty) < $quantity) {
                return redirect()->back()->with('error', "The available quantity for product : $product->product_name is less than required");
            }
            $stock->out_qty += $quantity;
            $stock->save();
        }
        // insert
        $inovice = Inovice::create([
            'customer_id' => $request->customer,
            'discreption' => $request->description,
            'total_before_discount' => $request->total_before_discount,
            'discount' => $request->discount,
            'total_after_discount' => $request->total_after_discount,
            'paid_status' => $request->paid_Status,
        ]);
        foreach ($request->category as $index => $category) {
            Inovice_items::create([
                'product_id' => $request->product[$index],
                'category_id' => $category,
                'quantity' => $request->quantity[$index],
                'price' => $request->price[$index],
                'total_all' => $request->total[$index],
                'invoice_No' => $inovice->id,
            ]);
        }
        Transaction::create([
            'type' => 'out',
            'product_id' => 1, // مش مهم كدا كدا احنا بنجيب عدد الجدول دا بس
            'qty' => 0,
        ]);
        return redirect()->route('inovice')->with('success', 'Invoice Added Successfully');
    }


    function destroy($id) {
        Inovice::destroy($id);

    return redirect()->route('inovice')->with('success', 'Inovice Deleted Successfully'); 
    }

    function view($id) {
        $invoice = Inovice::with('customer')->where('id', $id)->get();
        $invoice_item = Inovice_items::with('category','product')->where('invoice_No', $id)->get();
        return view('invoice_view', ['invoices' => $invoice , 'invoice_items' => $invoice_item]);
    }

    function edit(Inovice $invoice) {
        // customer
        $customers = Customers::select('id', 'customer_name')->get();
        // category
        $categories = Category::select('category', 'id')->get();
        // product
        $product = Product::select('product_name', 'id')->get();
        //invoice_items
        $invoice_items = Inovice_items::with('category','product')->where('invoice_No', $invoice->id)->get();
        return view('invoice_edit', ['invoice_items' => $invoice_items , 'invoice' => $invoice , 'customers' => $customers , 'categories' => $categories , 'products' => $product]);
    }

public function update(Request $request)
{
    $request->validate([
        'category' => 'required|array',
        'product' => 'required|array',
        'quantity' => 'required|array',
        'price' => 'required|array',
        'total' => 'required|array',
        'discount' => 'nullable|numeric',
        'total_before_discount' => 'required|numeric',
        'total_after_discount' => 'required|numeric',
        'description' => 'nullable|string',
        'paid_Status' => 'required',
        'customer' => 'required|integer',
    ]);

    $invoice = Inovice::findOrFail($request->id);

    $invoice->update([
        'customer_id' => $request->customer,
        'discreption' => $request->description,
        'total_before_discount' => $request->total_before_discount,
        'discount' => $request->discount,
        'total_after_discount' => $request->total_after_discount,
        'paid_status' => $request->paid_Status,
    ]);

    $oldItems = Inovice_items::where('invoice_No', $invoice->id)->get();
    $oldCount = $oldItems->count();
    $newCount = count($request->product);

    for ($i = 0; $i < max($oldCount, $newCount); $i++) {
        if ($i < $newCount && $i < $oldCount) {
            $oldItem = $oldItems[$i];
            $oldProductId = $oldItem->product_id;
            $oldQty = $oldItem->quantity;
            $newProductId = $request->product[$i];
            $newQty = $request->quantity[$i];

            // ✅ لو المنتج اتغير
            if ($oldProductId != $newProductId) {
                // رجّع الكمية للمنتج القديم
                $oldStock = Stock::where('product_id', $oldProductId)->first();
                if ($oldStock) {
                    $oldStock->out_qty -= $oldQty;
                    $oldStock->save();
                }

                // اسحب من المنتج الجديد
                $newStock = Stock::where('product_id', $newProductId)->first();
                if ($newStock && $newStock->stock >= $newQty) {
                    $newStock->out_qty += $newQty;
                    $newStock->save();
                } else {
                $product =  Product::find($newProductId);
                    return back()->withErrors(['stock' => "The quantity is insufficient for the product $product->product_name "]);
                }
            } else {
                // ✅ نفس المنتج - حدث الكمية
                $diff = $newQty - $oldQty;
                $stock = Stock::where('product_id', $oldProductId)->first();
                if ($stock && $stock->stock >= $diff) {
                    $stock->out_qty += $diff;
                    $stock->save();
                } else {
                $product =  Product::find($oldProductId);
                    return back()->withErrors(['stock' => "The quantity is insufficient for the product $product->product_name "]);
                }
            }

            // تحديث بيانات العنصر
            $oldItem->update([
                'product_id' => $newProductId,
                'category_id' => $request->category[$i],
                'quantity' => $newQty,
                'price' => $request->price[$i],
                'total_all' => $request->total[$i],
            ]);

        } elseif ($i >= $oldCount) {
            // ✅ عنصر جديد
            $product_id = $request->product[$i];
            $qty = $request->quantity[$i];
            $stock = Stock::where('product_id', $product_id)->first();

            if ($stock && $stock->stock >= $qty) {
                $stock->out_qty += $qty;
                $stock->save();
            } else {
                return back()->withErrors(['stock' => "الكمية غير كافية للمنتج رقم $product_id."]);
            }

            Inovice_items::create([
                'product_id' => $product_id,
                'category_id' => $request->category[$i],
                'quantity' => $qty,
                'price' => $request->price[$i],
                'total_all' => $request->total[$i],
                'invoice_No' => $invoice->id,
            ]);

        } elseif ($i >= $newCount) {
            // ✅ حذف العنصر
            $oldItem = $oldItems[$i];
            $stock = Stock::where('product_id', $oldItem->product_id)->first();
            if ($stock) {
                $stock->out_qty -= $oldItem->quantity;
                $stock->save();
            }
            $oldItem->delete();
        }
    }

    return redirect()->route('inovice')->with('success', 'Invoice updated successfully');
}



}