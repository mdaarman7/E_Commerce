<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;

class ProductController extends Controller
{
    // List all products
    public function index()
    {
        $products = Product::where('user_id', Auth::user()?->id)->get();

        return view('products.index', compact('products'));
    }
    public function shop()
    {
        $products = Product::inRandomOrder()->get();

        return view('shop.index', compact('products'));
    }

    // Show add product form
    public function create()
    {
        return view('products.create');
    }

    // Store product
    public function store(Request $request)
    {
        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('Product_Images', 'public');
        }

        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $imagePath,

            'user_id' => Auth::user()?->id
        ]);

        return redirect('/seller/products');
    }

    // Show edit form
    public function edit($id)
    {
        $product = Product::where('id', $id)
            ->where('user_id', Auth::user()?->id)
            ->firstOrFail();

        return view('products.edit', compact('product'));
    }

    // Update product
    public function update(Request $request, $id)
    {
        $product = Product::where('id', $id)
            ->where('user_id', Auth::user()?->id)
            ->firstOrFail();

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $imagePath = $request->file('image')->store('Product_Images', 'public');
            $product->image = $imagePath;
        }

        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
        ]);

        return redirect('/seller/products');
    }

    // Delete product
    public function destroy($id)
    {
        $product = Product::where('id', $id)
            ->where('user_id', Auth::user()?->id)
            ->firstOrFail();
            
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        $product->delete();
        return redirect('/seller/products');
    }
}
