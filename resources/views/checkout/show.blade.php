<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Order {{ $order->order_number }}
        </h2>
    </x-slot>

    <div class="mx-auto max-w-5xl p-6 lg:p-10">
        @if (session('success'))
            <div class="mb-4 rounded border border-green-200 bg-green-50 px-4 py-3 text-green-700">
                {{ session('success') }}
            </div>
        @endif

        <div class="rounded border bg-white p-6 shadow-sm">
            <div class="flex flex-col gap-4 border-b pb-5 md:flex-row md:items-start md:justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Thanks, {{ $order->customer_name }}</h3>
                    <p class="mt-1 text-gray-500">Your order has been received and is currently {{ $order->status }}.</p>
                </div>
                <div class="text-sm text-gray-600 md:text-right">
                    <p class="font-medium text-gray-800">{{ $order->order_number }}</p>
                    <p>{{ $order->created_at->format('M d, Y h:i A') }}</p>
                </div>
            </div>

            <div class="grid gap-6 py-6 md:grid-cols-2">
                <div>
                    <h4 class="mb-2 font-semibold text-gray-800">Delivery Address</h4>
                    <p class="text-gray-600">{{ $order->address }}</p>
                    <p class="text-gray-600">{{ $order->city }}</p>
                    <p class="text-gray-600">{{ $order->phone }}</p>
                    <p class="text-gray-600">{{ $order->email }}</p>
                </div>

                <div>
                    <h4 class="mb-2 font-semibold text-gray-800">Payment</h4>
                    <p class="text-gray-600">Cash on Delivery</p>
                    @if($order->notes)
                        <h4 class="mb-2 mt-4 font-semibold text-gray-800">Notes</h4>
                        <p class="text-gray-600">{{ $order->notes }}</p>
                    @endif
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full border text-left">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="border px-4 py-2">Product</th>
                            <th class="border px-4 py-2">Quantity</th>
                            <th class="border px-4 py-2">Unit Price</th>
                            <th class="border px-4 py-2">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                            <tr>
                                <td class="border px-4 py-2">{{ $item->product_name }}</td>
                                <td class="border px-4 py-2">{{ $item->quantity }}</td>
                                <td class="border px-4 py-2">Rs {{ number_format($item->unit_price, 2) }}</td>
                                <td class="border px-4 py-2">Rs {{ number_format($item->subtotal, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="border px-4 py-3 text-right font-bold">Total</td>
                            <td class="border px-4 py-3 font-bold">Rs {{ number_format($order->total_amount, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="mt-6 flex justify-between">
                <a href="{{ route('checkout.index') }}" class="rounded border px-4 py-2 font-medium text-gray-700 hover:bg-gray-50">
                    View Orders
                </a>
                <a href="{{ route('shop.index') }}" class="rounded bg-blue-600 px-4 py-2 font-medium text-white hover:bg-blue-700">
                    Continue Shopping
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
