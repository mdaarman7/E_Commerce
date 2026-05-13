<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            My Orders
        </h2>
    </x-slot>

    <div class="mx-auto max-w-5xl p-6 lg:p-10">
        <div class="rounded border bg-white shadow-sm">
            @forelse($orders as $order)
                <a href="{{ route('checkout.show', $order) }}"
                    class="block border-b p-5 transition hover:bg-gray-50 last:border-b-0">
                    <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                        <div>
                            <p class="font-semibold text-gray-800">{{ $order->order_number }}</p>
                            <p class="text-sm text-gray-500">
                                {{ $order->created_at->format('M d, Y h:i A') }} |
                                {{ $order->items->count() }} item(s)
                            </p>
                        </div>
                        <div class="flex items-center gap-4 md:text-right">
                            <span class="rounded bg-yellow-100 px-3 py-1 text-sm font-medium text-yellow-800">
                                {{ ucfirst($order->status) }}
                            </span>
                            <span class="font-bold text-gray-900">
                                Rs {{ number_format($order->total_amount, 2) }}
                            </span>
                        </div>
                    </div>
                </a>
            @empty
                <div class="p-8 text-center">
                    <h3 class="text-lg font-semibold text-gray-800">No orders yet</h3>
                    <p class="mt-1 text-gray-500">Your completed checkouts will appear here.</p>
                    <a href="{{ route('shop.index') }}"
                        class="mt-4 inline-block rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700">
                        Start Shopping
                    </a>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
