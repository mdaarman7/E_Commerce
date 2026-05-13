<x-app-layout>
    <x-slot name="header">
        <h2>My Cart</h2>
    </x-slot>

    <div class="p-10">
        @if (session('success'))
            <div class="mb-4 rounded border border-green-200 bg-green-50 px-4 py-3 text-green-700">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 rounded border border-red-200 bg-red-50 px-4 py-3 text-red-700">
                {{ session('error') }}
            </div>
        @endif

        @error('cart')
            <div class="mb-4 rounded border border-red-200 bg-red-50 px-4 py-3 text-red-700">
                {{ $message }}
            </div>
        @enderror

        @php
            $total = 0;
        @endphp

        @forelse($carts as $cart)

        @php
            $total += $cart->product->price * $cart->quantity;
        @endphp

        <div class="flex gap-5 items-center border p-4 mb-4 rounded">

            <!-- Image -->
            <img
                src="{{ asset('storage/'.$cart->product->image) }}"
                class="w-24 h-24 object-cover rounded">

            <!-- Product Info -->
            <div class="flex-1">
                <h3 class="font-semibold text-lg">
                    {{ $cart->product->name }}
                </h3>
                <p>Rs {{ $cart->product->price }}</p>
                <p class="text-sm text-gray-500">Available: {{ $cart->product->stock }}</p>

                <!-- Quantity Controls -->
                <div class="flex items-center gap-3 mt-2">
                    <!-- Decrease -->
                    <form method="POST" action="{{ route('cart.decrease',$cart->id) }}">
                        @csrf
                        <button class="bg-gray-300 px-3 py-1 rounded">-</button>
                    </form>

                    <!-- Quantity -->
                    <span class="font-bold text-lg">
                        {{ $cart->quantity }}
                    </span>

                    <!-- Increase -->
                    <form method="POST" action="{{ route('cart.increase',$cart->id) }}">
                        @csrf
                        <button class="bg-gray-300 px-3 py-1 rounded">+</button>
                    </form>
                </div>
            </div>
            
            <!-- Remove Button -->
            <form method="POST"
                action="{{ route('cart.remove',$cart->id) }}">

                @csrf
                @method('DELETE')
                <button
                    class="bg-red-500 text-white px-4 py-2 rounded">
                    Remove
                </button>
            </form>

        </div>
        @empty
            <div class="rounded border bg-white p-8 text-center">
                <h3 class="text-lg font-semibold text-gray-800">Your cart is empty</h3>
                <p class="mt-1 text-gray-500">Add products from the shop before checking out.</p>
                <a href="{{ route('shop.index') }}"
                    class="mt-4 inline-block rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700">
                    Continue Shopping
                </a>
            </div>
        @endforelse

        <!-- Total Price -->
        @if ($carts->count() > 0)
            <div class="mt-6 flex flex-col items-end gap-4">
                <h3 class="text-xl font-bold border p-4 inline-block rounded">
                    Total: Rs {{ number_format($total, 2) }}
                </h3>
                <a href="{{ route('checkout.create') }}"
                    class="rounded bg-green-600 px-6 py-3 font-semibold text-white hover:bg-green-700">
                    Proceed to Checkout
                </a>
            </div>
        @endif
    </div>
</x-app-layout>
