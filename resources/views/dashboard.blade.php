<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 text-center">
                <h2 class="text-xl font-bold mb-6">Escoge entre las categorías</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Primera columna con imagen -->
                    <a href="/creations">
                        <div class="relative">
                            <img src="{{ asset('images/cocreemos.jpg') }}" alt="Categoría 1" class="w-full h-auto rounded-lg shadow-lg hover:opacity-75 transition duration-300">
                            <div class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-50 opacity-0 hover:opacity-100 transition duration-300 rounded-lg">
                                <span class="text-white text-2xl font-bold">Categoría 1</span>
                            </div>
                        </div>
                    </a>
    
                    <!-- Segunda columna con imagen -->
                    <a href="/innovations">
                        <div class="relative">
                            <img src="{{ asset('images/innovaciones.jpg') }}" alt="Categoría 2" class="w-full h-auto rounded-lg shadow-lg hover:opacity-75 transition duration-300">
                            <div class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-50 opacity-0 hover:opacity-100 transition duration-300 rounded-lg">
                                <span class="text-white text-2xl font-bold">Categoría 2</span>
                            </div>
                        </div>
                    </a>

                    <!-- Segunda columna con imagen -->
                    <a href="/innovations">
                        <div class="relative">
                            <img src="{{ asset('images/mejorvideo.jpg') }}" alt="Categoría 2" class="w-full h-auto rounded-lg shadow-lg hover:opacity-75 transition duration-300">
                            <div class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-50 opacity-0 hover:opacity-100 transition duration-300 rounded-lg">
                                <span class="text-white text-2xl font-bold">Categoría 2</span>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
