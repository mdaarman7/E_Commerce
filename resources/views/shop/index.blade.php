<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Shop
        </h2>
    </x-slot>

    <div class="py-10 px-10">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">

            @foreach($products as $product)

            <div class="bg-white rounded-xl shadow hover:shadow-lg transition overflow-hidden">
                <img
                    onclick="openModal('{{ $product->name }}', '{{ $product->description }}', '{{ $product->price }}',
                                    '{{ $product->stock }}','{{ asset('/storage/'.$product->image) }}')"
                    onhover="this.style.cursor='pointer'"
                    src="{{ asset('storage/'.$product->image) }}"
                    class="w-full h-48 object-cover">
                <div class="p-4">
                    <h3 class="font-semibold text-lg">
                        {{ $product->name }}
                    </h3>
                    <p class="text-gray-500 text-sm mt-1">

                        Rs {{ $product->price }}

                    </p>
                    <button
                        onclick="openModal('{{ $product->name }}', '{{ $product->description }}', '{{ $product->price }}',
                                                    '{{ $product->stock }}','{{ asset('/storage/'.$product->image) }}'
)"
                        class="mt-3 w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">

                        View Product

                    </button>
                </div>
            </div>
            @endforeach

            <!-- POPUP MODAL -->
            <div id="productModal"
                onclick="outsideClick(event)"
                class="fixed inset-0 bg-black bg-opacity-60 hidden items-center justify-center z-50">

                <div class="bg-white rounded-xl p-6 w-96 relative shadow-xl">

                    <!-- close button -->
                    <button onclick="closeModal()"
                        class="absolute top-2 right-3 text-xl font-bold">

                        ✖

                    </button>


                    <!-- image -->
                    <img id="modalImage"
                        class="w-full h-52 object-cover rounded">


                    <!-- details -->
                    <h2 id="modalName"
                        class="text-xl font-bold mt-3"></h2>


                    <p id="modalDesc"
                        class="text-gray-600 mt-2"></p>


                    <p id="modalPrice"
                        class="text-lg font-semibold mt-2 text-green-600"></p>


                    <p id="modalStock"
                        class="text-gray-500"></p>

                </div>

            </div>
        </div>
    </div>
</x-app-layout>

<script>
    function openModal(name, desc, price, stock, image) {
        document.getElementById('modalName').innerText = name;
        document.getElementById('modalDesc').innerText = desc;
        document.getElementById('modalPrice').innerText = "Rs " + price;
        document.getElementById('modalStock').innerText = "Stock: " + stock;
        document.getElementById('modalImage').src = image;
        document.getElementById('productModal').classList.remove('hidden');
        document.getElementById('productModal').classList.add('flex');
    }

    function closeModal() {
        document.getElementById('productModal').classList.add('hidden');
    }

    function outsideClick(event) {
        let modal = document.getElementById('productModal');
        if (event.target === modal) {
            closeModal();
        }
    }
</script>