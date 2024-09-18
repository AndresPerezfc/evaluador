<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 mt-36">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 text-center">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Primera columna con imagen -->
                    <a href="#">
                        <div class="relative">
                            <img src="{{ asset('images/cocreemos.png') }}" alt="cocreemos" class="w-full h-auto rounded-lg shadow-lg hover:opacity-75 transition duration-300">
                            <div class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-50 opacity-0 hover:opacity-100 transition duration-300 rounded-lg">
                                <span class="text-white text-2xl font-bold">Co-Creemos</span>
                            </div>
                        </div>
                    </a>
    
                    <!-- Segunda columna con imagen -->
                    <a href="#">
                        <div class="relative">
                            <img src="{{ asset('images/innovaciones.png') }}" alt="Categoría 2" class="w-full h-auto rounded-lg shadow-lg hover:opacity-75 transition duration-300">
                            <div class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-50 opacity-0 hover:opacity-100 transition duration-300 rounded-lg">
                                <span class="text-white text-2xl font-bold">Tus Innovaciones</span>
                            </div>
                        </div>
                    </a>

                    <!-- tercera columna con imagen -->
                    <a href="/videos">
                        <div class="relative">
                            <img src="{{ asset('images/mejorvideo.png') }}" alt="Categoría 2" class="w-full h-auto rounded-lg shadow-lg hover:opacity-75 transition duration-300">
                            <div class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-50 opacity-0 hover:opacity-100 transition duration-300 rounded-lg">
                                <span class="text-white text-2xl font-bold">Mejor video educationa nacional</span>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
