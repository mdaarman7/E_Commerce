<x-app-layout>
    <x-slot name="header">
        <h2>My Cart</h2>
    </x-slot>

    <div class="p-10">

        @php
            $total = 0;
        @endphp

        @foreach($carts as $cart)

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
        @endforeach

        <!-- Total Price -->
        <div class="text-right mt-6">
            @if ($carts->count() > 0)
                <h3 class="text-xl font-bold border p-4 inline-block rounded">
                    Total: Rs {{ $total }}
                </h3>
            @endif
        </div>
    </div>
</x-app-layout>