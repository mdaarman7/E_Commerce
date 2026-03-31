<x-app-layout>

    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">
                Products
            </h2>
            @guest
            <div class="flex gap-4">
                <a href="{{ route('login') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                    Login
                </a>
                <a href="{{ route('register') }}" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
                    Register
                </a>
            </div>
            @endguest
        </div>
    </x-slot>

    <div class="py-10 px-10">

        <div class="grid grid-cols-4 gap-6">

            @foreach($products as $product)

                <div class="bg-white shadow rounded p-4">

                    <img src="{{ asset('storage/'.$product->image) }}"
                         class="w-full h-40 object-cover">

                    <h3 class="font-bold mt-2">
                        {{ $product->name }}
                    </h3>

                    <p class="text-gray-600">
                        Rs {{ $product->price }}
                    </p>

                </div>

            @endforeach

        </div>

    </div>

</x-app-layout>