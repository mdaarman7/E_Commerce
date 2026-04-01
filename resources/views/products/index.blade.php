<x-app-layout>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Products</h1>
        @if(auth()->user()->role == 'seller')

        <a href="{{ route('products.create') }}"
            class="bg-blue-500 text-white px-4 py-2 rounded">
            Add Product
        </a>
        @endif

        <table class="min-w-full bg-white border">
            <thead>
                <tr>
                    <th class="border px-4 py-2">ID</th>
                    <th class="border px-4 py-2">Name</th>
                    <th class="border px-4 py-2">Price</th>
                    <th class="border px-4 py-2">Stock</th>
                    <th class="border px-4 py-2">Image</th>
                    <th class="border px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr>
                    <td class="border px-4 py-2">{{ $product->id }}</td>
                    <td class="border px-4 py-2">{{ $product->name }}</td>
                    <td class="border px-4 py-2">${{ $product->price }}</td>
                    <td class="border px-4 py-2">{{ $product->stock }}</td>
                    <td class="border px-4 py-2">
                        @if($product->image)
                        <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}" class="w-16 h-16 object-cover">
                        @else
                        N/A
                        @endif
                    </td>
                    <td class="border px-4 py-2">
                        <div class="flex gap-2 items-center">

                            <!-- Edit Button -->
                            <a href="{{ route('products.edit', $product->id) }}"
                                class="bg-yellow-400 text-white p-2 rounded hover:bg-yellow-500 transition flex items-center justify-center"
                                title="Edit">

                                <!-- Edit SVG Icon -->
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="w-5 h-5"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor">

                                    <path stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M15.232 5.232l3.536 3.536M9 13l6.768-6.768a2.5 2.5 0 013.536 3.536L12.536 16.536a4 4 0 01-1.414.943L8 18l.521-3.121A4 4 0 019.464 13z" />
                                </svg>
                            </a>


                            <!-- Delete Button -->
                            <form action="{{ route('products.destroy', $product->id) }}"
                                method="POST"
                                class="inline-block">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                    class="bg-red-500 text-white p-2 rounded hover:bg-red-600 transition flex items-center justify-center"
                                    title="Delete"
                                    onclick="return confirm('Are you sure you want to delete this product?')">

                                    <!-- Delete SVG Icon -->
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="w-5 h-5"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor">

                                        <path stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M6 7h12M9 7V4h6v3M10 11v6M14 11v6M5 7l1 13a2 2 0 002 2h8a2 2 0 002-2l1-13" />
                                    </svg>

                                </button>

                            </form>

                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="border px-4 py-2 text-center text-gray-500">
                        No products found. <a href="{{ route('products.create') }}" class="text-blue-500 underline">Add your first product</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>