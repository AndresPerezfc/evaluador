@props(['breadcrumb' => []])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $creation->titulo }} - Co-creemos</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Font awesome -->
    <script src="https://kit.fontawesome.com/1a79ad85b4.js" crossorigin="anonymous"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles
</head>

<body x-data="{
    open: false,
    isOpen: false
}":class="{'overflow-hidden': open}" class="sm:overflow-auto">

    <nav style="background: linear-gradient(75deg, #FF8957 23%, #FF5F69 100%);"
        class="fixed top-0 z-50 w-full border-b border-gray-200">
        <div class="px-3 py-3 lg:px-5 lg:pl-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center justify-start rtl:justify-end">
                    <button x-on:click="open = !open" data-drawer-target="logo-sidebar"
                        data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button"
                        class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200">
                        <span class="sr-only">Open sidebar</span>
                        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path clip-rule="evenodd" fill-rule="evenodd"
                                d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
                            </path>
                        </svg>
                    </button>
                    <a href="/" class="flex ms-2 md:me-24">
                        <img src="{{ asset('images/logo.png') }}" class="h-14 me-3" alt="Logo innovafest" />
                    </a>
                </div>
                <!-- Título centrado -->
                <div class="flex-grow">
                    <h1 class="text-2xl ml-7 text-white font-semibold">
                        {{ $creation->titulo }}
                    </h1>
                </div>
                <div class="flex items-center">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                <button
                                    class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                    <img class="h-8 w-8 rounded-full object-cover"
                                        src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                </button>
                            @else
                                <span class="inline-flex rounded-md">
                                    <button type="button"
                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                        {{ Auth::user()->name }}

                                        <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                        </svg>
                                    </button>
                                </span>
                            @endif
                        </x-slot>

                        <x-slot name="content">
                            <!-- Account Management -->
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ __('Manage Account') }}
                            </div>

                            <x-dropdown-link href="{{ route('profile.show') }}">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                <x-dropdown-link href="{{ route('api-tokens.index') }}">
                                    {{ __('API Tokens') }}
                                </x-dropdown-link>
                            @endif

                            <div class="border-t border-gray-200"></div>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}" x-data>
                                @csrf

                                <x-dropdown-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>
        </div>
    </nav>

    @php
        $links = [
            [
                'name' => 'Co-creemos',
                'icon' => 'fa-solid fa-people-group',
                'active' => true,
                'route' => '/creations',
            ],

            [
                'name' => 'Tus Innovaciones',
                'icon' => 'fa-solid fa-lightbulb',
                'route' => '/innovations',
                'active' => false,
            ],

            [
                'name' => 'Mejor video educativo',
                'icon' => 'fa-solid fa-chalkboard-user',
                'route' => '',
                'active' => false,
            ],
        ];
    @endphp

    <aside id="logo-sidebar"
        class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0 mt-8"
        :class="{
            'transform-none': open,
            '-translate-x-full': !open,
        }"
        aria-label="Sidebar">
        <div class="h-full px-3 pb-4 overflow-y-auto bg-white">
            <ul class="space-y-2 font-medium">

                @foreach ($links as $link)
                    <li>

                        @isset($link['header'])
                            <div class="px-3 py-2 text-xs font-semibold text-gray-500 uppercase">
                                {{ $link['header'] }}
                            </div>
                        @else
                            @isset($link['submenu'])
                                <div x-data="{ open: {{ $link['active'] ? 'true' : 'false' }} }">
                                    <button
                                        class="flex items-center w-full p-2 text-gray-900 rounded-lg group {{ $link['active'] ? 'bg-gray-100' : '' }}"
                                        x-on:click="open = !open">
                                        <span class="inline-flex w-6 h-6 justify-center items-center">
                                            <i class="{{ $link['icon'] }} text-gray-500"></i>
                                        </span>
                                        <span class="ms-3 text-left flex-1">{{ $link['name'] }}</span>


                                        <!-- Ajustar el icono con transform y rotate manualmente -->
                                        <i class="fa-solid fa-angle-down transition-transform duration-300 ease-in-out"
                                            :class="open ? 'transform rotate-180' : 'transform rotate-0'"></i>

                                    </button>

                                    <!-- Añadir transición suave al submenú -->
                                    <ul x-show="open" x-transition x-cloak
                                        class="transition-all duration-700 ease-in-out transform origin-top">
                                        @foreach ($link['submenu'] as $item)
                                            <li class="pl-4">
                                                <a href="{{ $item['route'] }}"
                                                    class="flex items-center w-full p-2 text-gray-900 rounded-lg  group {{ $item['active'] ? 'bg-gray-100' : '' }}">

                                                    <span class="inline-flex w-6 h-6 justify-center items-center">
                                                        <i class="{{ $item['icon'] }} text-gray-500"></i>
                                                    </span>
                                                    <span class="ms-3 text-left flex-1">{{ $item['name'] }}</span>

                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @else
                                <a href="{{ $link['route'] }}"
                                    class="flex items-center p-2 text-gray-900 rounded-lg  group {{ $link['active'] ? 'bg-gray-100' : '' }}">
                                    <span class="inline-flex w-6 h-6 justify-center items-center">
                                        <i class="{{ $link['icon'] }} text-gray-500"></i>
                                    </span>
                                    <span class="ms-3">{{ $link['name'] }}</span>
                                </a>
                            @endisset
                        @endisset
                    </li>
                @endforeach
            </ul>
        </div>
    </aside>


    <div class="p-4 sm:ml-64">
        <div class="mt-14">
            <div class="p-4 rounded-lg">

                {{-- Contenido --}}

                <div class="container mx-auto my-8 p-6 bg-white shadow rounded-lg">

                    <!-- Contenedor para las dos columnas -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

                        <!-- Columna 1: Video de presentación -->
                        <div class="aspect-w-16 aspect-h-9 p-2 rounded-md shadow-md flex items-center justify-center">
                            @if (!empty($creation->incrustable))
                                {!! $creation->incrustable !!}
                            @else
                                <p class="text-center text-gray-500">Sin video de presentación <br>
                                    {{ $creation->presentacion }}</p>
                            @endif
                        </div>

                        <!-- Columna 2: Datos -->
                        <div class="flex flex-col justify-between space-y-6">
                            <!-- Puntaje Actual -->
                            <div class="grid grid-cols-3 gap-4">
                                <div class="p-4 rounded-md shadow-md">
                                    <h2 class="text-2xl font-medium mb-2">Puntaje Actual</h2>
                                    @php
                                        $puntaje = $creation->puntaje;
                                        $textColorClass = 'text-red-500'; // Valor por defecto
                                
                                        if ($puntaje >= 80) {
                                            $textColorClass = 'text-green-600';
                                        } elseif ($puntaje > 49) {
                                            $textColorClass = 'text-yellow-500';
                                        }
                                    @endphp
                                    <div class="text-2xl font-bold {{ $textColorClass }}">
                                        {{ number_format($puntaje, 1) }} / 100
                                    </div>
                                </div>

                                <div class="p-4 rounded-md shadow-md">
                                    <h2 class="text-2xl font-medium mb-2">Rol</h2>
                                    <div class="text-2xl font-bold text-green-600">
                                        {{ $creation->rol_autor }}
                                    </div>
                                </div>

                                <div class="p-4 rounded-md shadow-md">
                                    <h2 class="text-2xl font-medium mb-2">Categoría</h2>
                                    <div class="text-2xl font-bold text-green-600">
                                        {{ $creation->categoria_autor }}
                                    </div>
                                </div>
                                
                            </div>


                            <!-- Datos de la Innovación -->
                            <div class="p-4 rounded-md shadow-md">
                                <h2 class="mb-2 text-2xl font-medium">Datos de la Innovación</h2>

                                <p class="mb-2"><strong>Nombre del creador:</strong> {{ $creation->cocreador }}
                                </p>

                                <p class="mb-2">
                                    <strong>Temática:</strong>
                                    {{ Str::limit($creation->tematica, 300) }}

                                    @if (strlen($creation->tematica) > 300)
                                        <a href="#" class="text-blue-600 hover:underline"
                                            data-modal-target="#descriptionModal-{{ $creation->id }}"
                                            data-modal-toggle="descriptionModal-{{ $creation->id }}">
                                            Ver más
                                        </a>
                                    @endif
                                </p>



                                <!-- Modal -->
                                <div id="descriptionModal-{{ $creation->id }}" tabindex="-1"
                                    class="fixed inset-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto bg-gray-800 bg-opacity-25 flex items-center justify-center">
                                    <div class="relative max-w-xl max-h-full w-full">
                                        <!-- Modal content -->
                                        <div
                                            class="relative bg-white max-w-2xl w-full max-h-[100vh] overflow-y-auto rounded-lg shadow">
                                            <!-- Modal header -->
                                            <div
                                                class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                                                <h3 class="text-xl font-medium text-gray-900">
                                                    Temática completa
                                                </h3>
                                                <button type="button"
                                                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                                                    data-modal-hide="descriptionModal-{{ $creation->id }}">
                                                    <svg class="w-3 h-3" aria-hidden="true"
                                                        xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 14 14">
                                                        <path stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="2"
                                                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                                    </svg>
                                                    <span class="sr-only">Cerrar</span>
                                                </button>
                                            </div>

                                            <!-- Modal body with scroll -->
                                            <div class="p-4 md:p-5 space-y-4 overflow-y-auto max-h-80">
                                                <p class="text-base leading-relaxed text-gray-500">
                                                    {{ $creation->tematica }}
                                                </p>
                                            </div>

                                            <!-- Modal footer -->
                                            <div
                                                class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b">
                                                <button data-modal-hide="descriptionModal-{{ $creation->id }}"
                                                    type="button"
                                                    class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">
                                                    Cerrar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                
                                @if (!empty($creation->problematica))
                                <p>
                                    <strong>Problemática:</strong>
                                    {{ Str::limit($creation->problematica, 300) }}

                                    @if (strlen($creation->problematica) > 300)
                                        <a href="#" class="text-blue-600 hover:underline"
                                            data-modal-target="#procesoModal-{{ $creation->id }}"
                                            data-modal-toggle="procesoModal-{{ $creation->id }}">
                                            Ver más
                                        </a>
                                    @endif
                                </p>
                                @endif

                                <!-- Modal -->
                                <div id="procesoModal-{{ $creation->id }}" tabindex="-1"
                                    class="fixed inset-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto bg-gray-800 bg-opacity-25 flex items-center justify-center">
                                    <div class="relative max-w-xl max-h-full w-full">
                                        <!-- Modal content -->
                                        <div
                                            class="relative bg-white max-w-2xl w-full max-h-[100vh] overflow-y-auto rounded-lg shadow">
                                            <!-- Modal header -->
                                            <div
                                                class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                                                <h3 class="text-xl font-medium text-gray-900">
                                                    Problemática completa
                                                </h3>
                                                <button type="button"
                                                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                                                    data-modal-hide="procesoModal-{{ $creation->id }}">
                                                    <svg class="w-3 h-3" aria-hidden="true"
                                                        xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 14 14">
                                                        <path stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="2"
                                                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                                    </svg>
                                                    <span class="sr-only">Cerrar</span>
                                                </button>
                                            </div>

                                            <!-- Modal body with scroll -->
                                            <div class="p-4 md:p-5 space-y-4 overflow-y-auto max-h-80">
                                                <p class="text-base leading-relaxed text-gray-500">
                                                    {{ $creation->problematica }}
                                                </p>
                                            </div>

                                            <!-- Modal footer -->
                                            <div
                                                class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b">
                                                <button data-modal-hide="procesoModal-{{ $creation->id }}"
                                                    type="button"
                                                    class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">
                                                    Cerrar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>

                            <!-- Datos del Innovador -->
                            <div class="p-4 rounded-md shadow-md">
                                <h2 class="text-2xl font-medium mb-4">Datos del Innovador</h2>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-gray-700">
                                    <div>
                                        <p><strong>Nombre:</strong> {{ $creation->cocreador }}</p>
                                        <p class="whitespace-nowrap truncate max-w-xs"><strong>Correo: </strong><a
                                                class="text-blue-600 hover:underline "
                                                href= "mailto:{{ $creation->email }}">{{ $creation->email }}</a>
                                        </p>
                                    </div>
                                    <div>
                                        <p><strong>Colegio:</strong> {{ $creation->colegio }}</p>
                                    </div>
                                    <div>
                                        @if (!empty($creation->facultad))
                                            <p><strong>Facultad:</strong> {{ $creation->facultad }}</p>
                                        @endif
                                        @if (!empty($creation->programa))
                                            <p><strong>Programa Académico:</strong> {{ $creation->programa }}</p>
                                        @endif
                                        @if (!empty($creation->dependencia))
                                            <p><strong>Dependencia:</strong> {{ $creation->dependencia }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Formulario de Evaluación -->
                    <div class="container mx-auto my-2 px-6 bg-white rounded-lg">

                        <!-- Formulario de Evaluación -->
                        <form action="{{ route('creations.update', $creation->id) }}" method="POST"
                            class="space-y-6">
                            @csrf
                            @method('PUT')

                            <!-- Criterios de Evaluación -->
                            <h3 class="text-2xl font-medium mb-4">Criterios de Evaluación</h3>

                            <!-- Contenedor con bordes y separaciones -->
                            <div
                                class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6 divide-y divide-gray-300 border border-gray-300 rounded-md">

                                @foreach ($criterios as $criterio)
                                    @php
                                        $evaluacion = $evaluaciones->get($criterio->id);
                                    @endphp

                                    <!-- Fila del criterio con bordes -->
                                    <div class="flex items-center p-4">
                                        <label for="criterio-{{ $criterio->id }}" class="text-lg font-semibold">
                                            {{ $criterio->name }} <span class="text-sm font-extralight">(Peso:
                                                {{ $criterio->score }})</span>
                                        </label>
                                    </div>

                                    <!-- Descripción del criterio -->
                                    <div class="flex items-center border-b border-gray-300 p-4">
                                        <p class=" text-gray-600">{{ $criterio->description }}</p>
                                    </div>

                                    <!-- Input para puntaje -->
                                    <div class="flex items-center border-b border-gray-300 p-4">
                                        <input type="hidden" name="criterios[{{ $loop->index }}][id]"
                                            value="{{ $criterio->id }}">
                                        <input type="number" name="criterios[{{ $loop->index }}][puntaje]"
                                            min="0" max="{{ $criterio->score }}"
                                            value="{{ $evaluacion->puntaje ?? '' }}" required
                                            class="border border-gray-300 p-2 w-full">
                                    </div>

                                    <!-- Input para comentario -->
                                    <div class="flex items-center border-b border-gray-300 p-4">
                                        <textarea name="criterios[{{ $loop->index }}][comentario]" placeholder="Comentario"
                                            class="border border-gray-300 p-2 w-full">{{ $evaluacion->comentario ?? '' }}</textarea>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Caja de texto para comentario general -->
                            <h3 class="text-2xl font-medium">Comentario general</h3>
                            <div class="flex items-center">
                                <textarea name="comentario_general" placeholder="Comentario general sobre la innovación"
                                    class="border border-gray-300 p-2 w-full rounded-md">{{ old('comentario_general', $creation->comentario_general ?? '') }}</textarea>
                            </div>

                            <!-- Botón Guardar -->
                            <div class="text-center mb-6">
                                <button type="submit"
                                    class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                    Guardar Evaluación
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                {{-- Contenido --}}

            </div>
        </div>
    </div>


    <div x-cloak x-show="open" x-on:click="open = false"
        class="bg-gray-900 bg-opacity-50 fixed inset-0 z-30 sm:hidden"></div>

    @stack('modals')

    @livewireScripts
</body>


<script>
    // Función para abrir el modal
    document.querySelectorAll('[data-modal-toggle]').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            const modalId = this.getAttribute('data-modal-target');
            document.querySelector(modalId).classList.remove('hidden');
        });
    });

    // Función para cerrar el modal
    document.querySelectorAll('[data-modal-hide]').forEach(button => {
        button.addEventListener('click', function() {
            const modalId = this.closest('.fixed');
            modalId.classList.add('hidden');
        });
    });
</script>

</html>
