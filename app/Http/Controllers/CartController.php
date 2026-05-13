<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function add($id)
    {
        $product = Product::findOrFail($id);

        $cart = Cart::where('user_id', Auth::id())
            ->where('product_id', $id)
            ->first();

        if ($product->stock < 1 || ($cart && $cart->quantity >= $product->stock)) {
            return back()->with('error', 'This product is out of stock.');
        }

        if ($cart) {
            $cart->quantity += 1;
            $cart->save();
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $id,
                'quantity' => 1
            ]);
        }
        return back()->with('success', 'Added to cart');
    }
    public function index()
    {
        $carts = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();
        return view('cart.index', compact('carts'));
    }
    public function remove($id)
    {
        Cart::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail()
            ->delete();

        return back();
    }
    // public function increase($id)
    // {
    //     $cart = Cart::where('id', $id)
    //         ->where('user_id', Auth::id())
    //         ->firstOrFail();
    //     $cart->quantity += 1;
    //     $cart->save();

    //     return back();
    // }
    public function increase($id)
    {
        $cart = Cart::with('product')
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if ($cart->quantity >= $cart->product->stock) {
            return back()->with('error', 'No more stock is available for this product.');
        }

        $cart->quantity += 1;
        $cart->save();
        return back();
    }
    // public function decrease($id)
    // {
    //     $cart = Cart::where('id', $id)
    //         ->where('user_id', Auth::id())
    //         ->firstOrFail();
    //     if ($cart->quantity > 1) {
    //         $cart->quantity -= 1;
    //         $cart->save();
    //     } else {
    //         $cart->delete();
    //     }
    // }
    public function decrease($id)
    {
        $cart = Cart::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if ($cart->quantity > 1) {
            $cart->quantity -= 1;
            $cart->save();
        } else {
            $cart->delete();
        }
        return back();
    }
}
