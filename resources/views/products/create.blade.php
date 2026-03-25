<x-app-layout>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Add Product</h1>

        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label class="block mb-1">Name</label>
                <input type="text" name="name" class="border px-2 py-1 w-full" required>
            </div>
            <div class="mb-4">
                <label class="block mb-1">Description</label>
                <textarea name="description" class="border px-2 py-1 w-full" required></textarea>
            </div>
            <div class="mb-4">
                <label class="block mb-1">Price</label>
                <input type="number" step="0.01" name="price" class="border px-2 py-1 w-full" required>
            </div>
            <div class="mb-4">
                <label class="block mb-1">Stock</label>
                <input type="number" name="stock" class="border px-2 py-1 w-full" required>
            </div>
            <div class="mb-4">
                <label class="block mb-1">Product Image</label>
                <input type="file" name="image" class="border px-2 py-1 w-full" required>
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Add Product</button>
        </form>
    </div>
</x-app-layout>