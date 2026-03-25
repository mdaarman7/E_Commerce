<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{

    // Show All Products
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }


    // Show Add Product Form
    public function create()
    {
        return view('products.create');
    }


    // Save Product To Database
    public function store(Request $request)
    {
        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $request->image,
            'stock' => $request->stock,
        ]);

        return redirect('/products');
    }


    // Show Edit Form
    public function edit($id)
    {
        $product = Product::find($id);
        return view('products.edit', compact('product'));
    }


    // Update Product
    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $request->image,
            'stock' => $request->stock,
        ]);

        return redirect('/products');
    }


    // Delete Product
    public function destroy($id)
    {
        Product::find($id)->delete();
        return redirect('/products');
    }

}