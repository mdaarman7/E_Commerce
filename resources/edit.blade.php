<x-app-layout>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Edit Product</h1>

        <form action="{{ route('products.update', $product->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block mb-1">Name</label>
                <input type="text" name="name" class="border px-2 py-1 w-full" value="{{ $product->name }}" required>
            </div>
            <div class="mb-4">
                <label class="block mb-1">Description</label>
                <textarea name="description" class="border px-2 py-1 w-full" required>{{ $product->description }}</textarea>
            </div>
            <div class="mb-4">
                <label class="block mb-1">Price</label>
                <input type="number" step="0.01" name="price" class="border px-2 py-1 w-full" value="{{ $product->price }}" required>
            </div>
            <div class="mb-4">
                <label class="block mb-1">Stock</label>
                <input type="number" name="stock" class="border px-2 py-1 w-full" value="{{ $product->stock }}" required>
            </div>
            <div class="mb-4">
                <label class="block mb-1">Image URL</label>
                <input type="text" name="image" class="border px-2 py-1 w-full" value="{{ $product->image }}">
            </div>
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Update Product</button>
        </form>
    </div>
</x-app-layout>