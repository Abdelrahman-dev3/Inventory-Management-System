<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class categoryController extends Controller
{
    function category(Request $request) {
            $search = $request->input('search');
            if (!empty($search)) {
                $categories = Category::where('category', 'LIKE', "%$search%")->get();
            }else{
                $categories = Category::all();
            }
        return view("category" , ['categories' => $categories]);
    }

    function add_category() {
        return view("add_category");
    }

        function store(Request $request) {
        // validition
        $request->validate([
            'category' => 'required|unique:categories,category',
        ]);
        // insert
        Category::create([
        'category' => $request->category,
    ]);
    return redirect()->route('category')->with('success', 'category Added Successfully');
    }


    function destroy($id) {
        Category::destroy($id);
    return redirect()->route('category')->with('success', 'Unit Deleted Successfully'); 
    }
}
