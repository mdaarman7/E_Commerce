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

        <div class="flex gap-5 items-center border p-3 mb-3">
            <img
                src="{{ asset('storage/'.$cart->product->image) }}"
                class="w-20">
            <div>
                <h3>
                    {{ $cart->product->name }}
                </h3>
                <p>
                    Rs {{ $cart->product->price }}
                </p>
                <p>
                    Qty: {{ $cart->quantity }}
                </p>
            </div>
            <form method="POST"
                action="{{ route('cart.remove',$cart->id) }}">

                @csrf
                @method('DELETE')
                <button
                    class="bg-red-500 text-white px-3 py-1 rounded">
                    Remove
                </button>
            </form>

        </div>
        @endforeach

        <div class="text-right">
            @if ($carts->count() > 0)
                <h3 class="text-xl font-bold border p-3 inline-block">
                Total: Rs {{ $total }}
                </h3>
            @endif
        </div>
    </div>
</x-app-layout>
