<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class CheckoutController extends Controller
{
    public function index()
    {
        $orders = Order::with('items')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('checkout.index', compact('orders'));
    }

    public function create()
    {
        $carts = $this->cartItems();

        if ($carts->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $this->ensureCartIsAvailable($carts);

        $total = $this->cartTotal($carts);

        return view('checkout.create', compact('carts', 'total'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'address' => ['required', 'string', 'max:1000'],
            'city' => ['required', 'string', 'max:255'],
            'notes' => ['nullable', 'string', 'max:1000'],
            'payment_method' => ['required', 'in:cash_on_delivery'],
        ]);

        $order = DB::transaction(function () use ($validated) {
            $carts = $this->cartItems();

            if ($carts->isEmpty()) {
                throw ValidationException::withMessages([
                    'cart' => 'Your cart is empty.',
                ]);
            }

            $products = Product::whereIn('id', $carts->pluck('product_id'))
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            $this->ensureCartIsAvailable($carts, $products);

            $order = Order::create([
                'user_id' => Auth::id(),
                'order_number' => $this->generateOrderNumber(),
                'customer_name' => $validated['customer_name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'address' => $validated['address'],
                'city' => $validated['city'],
                'notes' => $validated['notes'] ?? null,
                'payment_method' => $validated['payment_method'],
                'status' => 'pending',
                'total_amount' => $this->cartTotal($carts, $products),
            ]);

            foreach ($carts as $cart) {
                $product = $products->get($cart->product_id);
                $subtotal = $product->price * $cart->quantity;

                $order->items()->create([
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'quantity' => $cart->quantity,
                    'unit_price' => $product->price,
                    'subtotal' => $subtotal,
                ]);

                $product->decrement('stock', $cart->quantity);
            }

            Cart::whereIn('id', $carts->pluck('id'))->delete();

            return $order;
        });

        return redirect()
            ->route('checkout.show', $order)
            ->with('success', 'Order placed successfully.');
    }

    public function show(Order $order)
    {
        abort_unless($order->user_id === Auth::id(), 403);

        $order->load('items.product');

        return view('checkout.show', compact('order'));
    }

    private function cartItems()
    {
        return Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();
    }

    private function cartTotal($carts, $products = null): float
    {
        return (float) $carts->sum(function ($cart) use ($products) {
            $product = $products?->get($cart->product_id) ?? $cart->product;

            return $product->price * $cart->quantity;
        });
    }

    private function ensureCartIsAvailable($carts, $products = null): void
    {
        foreach ($carts as $cart) {
            $product = $products?->get($cart->product_id) ?? $cart->product;

            if (! $product) {
                throw ValidationException::withMessages([
                    'cart' => 'One of the products in your cart is no longer available.',
                ]);
            }

            if ($cart->quantity > $product->stock) {
                throw ValidationException::withMessages([
                    'cart' => "{$product->name} only has {$product->stock} item(s) left in stock.",
                ]);
            }
        }
    }

    private function generateOrderNumber(): string
    {
        do {
            $number = 'ORD-'.now()->format('Ymd').'-'.Str::upper(Str::random(6));
        } while (Order::where('order_number', $number)->exists());

        return $number;
    }
}
