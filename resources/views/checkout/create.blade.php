<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Checkout
        </h2>
    </x-slot>

    <div class="mx-auto max-w-6xl p-6 lg:p-10">
        @error('cart')
            <div class="mb-4 rounded border border-red-200 bg-red-50 px-4 py-3 text-red-700">
                {{ $message }}
            </div>
        @enderror

        <div class="grid gap-6 lg:grid-cols-3">
            <form method="POST" action="{{ route('checkout.store') }}" class="lg:col-span-2 rounded border bg-white p-6 shadow-sm">
                @csrf

                <h3 class="mb-5 text-lg font-semibold text-gray-800">Delivery Details</h3>

                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Full Name</label>
                        <input type="text" name="customer_name" value="{{ old('customer_name', auth()->user()->name) }}"
                            class="w-full rounded border-gray-300" required>
                        @error('customer_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}"
                            class="w-full rounded border-gray-300" required>
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Phone</label>
                        <input type="text" name="phone" value="{{ old('phone') }}"
                            class="w-full rounded border-gray-300" required>
                        @error('phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">City</label>
                        <input type="text" name="city" value="{{ old('city') }}"
                            class="w-full rounded border-gray-300" required>
                        @error('city')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-4">
                    <label class="mb-1 block text-sm font-medium text-gray-700">Delivery Address</label>
                    <textarea name="address" rows="4" class="w-full rounded border-gray-300" required>{{ old('address') }}</textarea>
                    @error('address')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-4">
                    <label class="mb-1 block text-sm font-medium text-gray-700">Order Notes</label>
                    <textarea name="notes" rows="3" class="w-full rounded border-gray-300">{{ old('notes') }}</textarea>
                    @error('notes')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-5 rounded border border-gray-200 bg-gray-50 p-4">
                    <label class="flex items-center gap-3">
                        <input type="radio" name="payment_method" value="cash_on_delivery" checked
                            class="border-gray-300 text-green-600">
                        <span>
                            <span class="block font-medium text-gray-800">Cash on Delivery</span>
                            <span class="text-sm text-gray-500">Pay when your order is delivered.</span>
                        </span>
                    </label>
                </div>

                <div class="mt-6 flex items-center justify-between">
                    <a href="{{ route('cart.index') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900">
                        Back to Cart
                    </a>
                    <button type="submit" class="rounded bg-green-600 px-6 py-3 font-semibold text-white hover:bg-green-700">
                        Place Order
                    </button>
                </div>
            </form>

            <aside class="rounded border bg-white p-6 shadow-sm">
                <h3 class="mb-5 text-lg font-semibold text-gray-800">Order Summary</h3>

                <div class="space-y-4">
                    @foreach($carts as $cart)
                        <div class="flex gap-3">
                            <img src="{{ asset('storage/'.$cart->product->image) }}"
                                class="h-16 w-16 rounded object-cover"
                                alt="{{ $cart->product->name }}">
                            <div class="flex-1">
                                <p class="font-medium text-gray-800">{{ $cart->product->name }}</p>
                                <p class="text-sm text-gray-500">
                                    {{ $cart->quantity }} x Rs {{ number_format($cart->product->price, 2) }}
                                </p>
                            </div>
                            <p class="font-medium">
                                Rs {{ number_format($cart->product->price * $cart->quantity, 2) }}
                            </p>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6 border-t pt-4">
                    <div class="flex justify-between text-lg font-bold">
                        <span>Total</span>
                        <span>Rs {{ number_format($total, 2) }}</span>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</x-app-layout>
