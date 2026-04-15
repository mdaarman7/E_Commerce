<x-app-layout>

    <x-slot name="header">

        <h2>My Cart</h2>

    </x-slot>

    <div class="p-10">

        @foreach($carts as $cart)
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

    </div>
</x-app-layout>