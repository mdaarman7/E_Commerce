<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ShopController extends Controller
{


    public function index(Request $request)
    {
        $search = $request->search;

        $products = Product::when($search, function ($query, $search) {
            $query->where('name', 'LIKE', "%{$search}%");
        })->latest()->get();

        return view('shop.index', compact('products', 'search'));
    }
}
