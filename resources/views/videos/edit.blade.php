@props(['breadcrumb' => []])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $video->titulo }} - Mejor video educativo nacional</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Font awesome -->
    <script src="https://kit.fontawesome.com/1a79ad85b4.js" crossorigin="anonymous"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    <style>
        .fl-container {
            top: 70px !important;
        }

        .fl-flasher .fl-message {
            font-size: 16px !important;
        }

        .fl-flasher.fl-success:not(.fl-rtl) {
            box-shadow: 0 -2px 6px -1px rgba(0, 0, 0, 0.05), 0 -2px 4px -1px rgba(0, 0, 0, 0.04);
        }
    </style>

    @livewireStyles
</head>

<body x-data="{
    open: false,
    isOpen: false
}":class="{'overflow-hidden': open}" class="sm:overflow-auto">

    <nav style="background: linear-gradient(90deg, #39B5E7 10%, #13B5C9 100%);"
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
                    <a href="/" class="flex ms-2 md:me-24 bg-white rounded-md">
                        <img src="{{ asset('images/logo.png') }}" class="h-12 me-3" alt="Logo innovafest" />
                    </a>
                </div>
                <!-- Título centrado -->
                <div class="flex-grow">
                    <h1 class="text-xl ml-7 text-white font-semibold">
                        {{ $video->titulo }}
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
                'active' => false,
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
                'route' => '/videos',
                'active' => true,
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

            <ul class="pt-4 mt-4 px-2 space-y-2 font-medium border-t border-gray-200">

                @if (auth()->check() && (auth()->user()->rol == 'superadmin' || auth()->user()->rol == 'evaluador'))
                    <h2 class="mb-2 text-lg font-semibold text-gray-900" style="margin-top: 10px"><span
                            class="inline-flex w-6 h-6 justify-center items-center">

                            @if (isset($puntajeUsuarioActual))
                                <i class="fa-solid fa-circle-check text-green-500"></i>
                            @else
                                <i class="fa-solid fa-circle-exclamation text-yellow-300"></i>
                            @endif
                        </span> Tu evaluación</h2>
                    @if (isset($puntajeUsuarioActual))
                        <p>Puntaje: {{ $puntajeUsuarioActual }} puntos</p>
                    @else
                        <p>Aún no has evaluado esta innovación.</p>
                    @endif
                @endif

                @if (isset($puntajeUsuarioActual))
                    <h2 class="mb-2 text-lg font-semibold text-gray-900" style="margin-top: 20px">
                        <span class="inline-flex w-6 h-6 justify-center items-center">
                            @if ($otrasEvaluaciones->isEmpty())
                                <i class="fa-solid fa-clipboard-check text-yellow-300"></i>
                            @else
                                <i class="fa-solid fa-clipboard-check text-green-500"></i>
                            @endif
                        </span> Evaluaciones
                    </h2>

                    <ul class="max-w-md space-y-1 text-gray-500">
                        @if ($otrasEvaluaciones->isEmpty())
                            <li>
                                <span class="text-red-500">Esta innovación aún no ha sido evaluada por otros
                                    evaluadores.</span>
                            </li>
                        @else
                            @foreach ($otrasEvaluaciones as $evaluacion)
                                <li class="border-t cursor-pointer" onclick="openModal({{ $evaluacion->user_id }})">
                                    <span class="font-semibold">{{ $evaluacion->user->name }}</span>:
                                    {{ $evaluacion->total_puntaje }} puntos
                                </li>
                            @endforeach
                        @endif
                    </ul>
                @endif

            </ul>
        </div>
    </aside>

    <!-- Modal -->
    <div id="modal-evaluacion"
        class="fixed inset-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto bg-gray-800 bg-opacity-25 flex items-center justify-center">
        <div class="relative w-1/2 max-h-[90vh]"> <!-- Ajustar altura máxima -->
            <!-- Modal content -->
            <div class="relative bg-white w-full max-h-[100vh] min-h-[400px] overflow-y-auto rounded-lg shadow">
                <!-- Añadir min-height -->
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                    <h2 class="text-xl font-semibold mb-3" id="evaluador-nombre"></h2>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                        data-modal-hide>
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Cerrar</span>
                    </button>
                </div>

                <!-- Modal body with scroll -->
                <div class="p-4 md:p-5 space-y-4 overflow-y-auto max-h-96"> <!-- Cambiar max-h-80 a max-h-96 -->
                    <p class="text-base leading-relaxed text-gray-500">
                    <div id="detalle-evaluacion" class="text-gray-700">
                        <!-- Aquí cargaremos los detalles dinámicamente -->
                    </div>
                    </p>
                </div>

                <!-- Modal footer -->
                <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b">
                    <button data-modal-hide type="button"
                        class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">
                        Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>



    <div class="p-4 sm:ml-64">
        <div class="mt-14">
            <div class="p-4 rounded-lg">

                @if (session('success'))
                    <div class="mt-14 p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                @endif

                {{-- Contenido --}}
                <div class="container mx-auto my-8 p-6 bg-white shadow rounded-lg">

                    <!-- Contenedor para las dos columnas -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

                        <!-- Columna 1: Video de presentación -->
                        <div class="aspect-w-16 aspect-h-9 p-2 rounded-md flex items-center justify-center">
                            @if (!empty($video->incrustable))
                                {!! $video->incrustable !!}
                            @else
                                <p class="text-center text-gray-500">Sin video de presentación <br>
                                    {{ $video->url_video }}</p>
                            @endif
                        </div>

                        <!-- Columna 2: Datos -->
                        <div class="flex flex-col space-y-6">
                            <!-- Puntaje Actual -->
                            <div class="grid grid-cols-2 gap-4">
                                <div class="p-4 rounded-md shadow-sm">
                                    <h2 class="text-2xl font-medium mb-2">Puntaje Actual</h2>
                                    @if (isset($puntajeUsuarioActual))
                                        @php
                                            $puntaje = $video->puntaje;
                                            $textColorClass = 'text-red-500'; // Valor por defecto

                                            if ($puntaje >= 80) {
                                                $textColorClass = 'text-green-600';
                                            } elseif ($puntaje > 49) {
                                                $textColorClass = 'text-yellow-500';
                                            }
                                        @endphp
                                        <div class="text-2xl font-bold {{ $textColorClass }}">
                                            {{ number_format($puntaje, 0) }} / 100
                                        </div>
                                    @else
                                        <p>Debes evaluar la innovación antes para ver su puntaje actual</p>
                                    @endif

                                </div>

                                <div class="p-4 rounded-md shadow-sm">
                                    <h2 class="text-2xl font-medium mb-2">Rol</h2>
                                    <div class="text-2xl font-bold">
                                        {{ $video->rol_autor }}
                                    </div>
                                </div>
                            </div>

                            <!-- Datos de la Innovación -->
                            <div class="p-4 rounded-md shadow-sm">
                                <h2 class="mb-2 text-2xl font-medium">Datos de la Innovación</h2>

                                @if (!empty($video->proposito))
                                    <p class="mb-2">
                                        <strong>Propósito:</strong>
                                        {{ Str::limit($video->proposito, 300) }}

                                        @if (strlen($video->proposito) > 300)
                                            <a href="#" class="text-blue-600 hover:underline"
                                                data-modal-target="#descriptionModal-{{ $video->id }}"
                                                data-modal-toggle="descriptionModal-{{ $video->id }}">
                                                Ver más
                                            </a>
                                        @endif
                                    </p>
                                @endif

                                <!-- Modal -->
                                <div id="descriptionModal-{{ $video->id }}" tabindex="-1"
                                    class="fixed inset-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto bg-gray-800 bg-opacity-25 flex items-center justify-center">
                                    <div class="relative w-1/2 max-h-full">
                                        <!-- Cambiado a w-1/2 para que ocupe la mitad de la pantalla -->
                                        <!-- Modal content -->
                                        <div
                                            class="relative bg-white w-full max-h-[100vh] overflow-y-auto rounded-lg shadow">
                                            <!-- Modal header -->
                                            <div
                                                class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                                                <h3 class="text-xl font-medium text-gray-900">
                                                    Propósito
                                                </h3>
                                                <button type="button"
                                                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                                                    data-modal-hide="descriptionModal-{{ $video->id }}">
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
                                                    {{ $video->proposito }}
                                                </p>
                                            </div>

                                            <!-- Modal footer -->
                                            <div
                                                class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b">
                                                <button data-modal-hide="descriptionModal-{{ $video->id }}"
                                                    type="button"
                                                    class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">
                                                    Cerrar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @if (!empty($video->publico_objetivo))
                                    <p>
                                        <strong>Público objetivo:</strong>
                                        {{ Str::limit($video->publico_objetivo, 300) }}

                                        @if (strlen($video->publico_objetivo) > 300)
                                            <a href="#" class="text-blue-600 hover:underline"
                                                data-modal-target="#procesoModal-{{ $video->id }}"
                                                data-modal-toggle="procesoModal-{{ $video->id }}">
                                                Ver más
                                            </a>
                                        @endif
                                    </p>
                                @endif

                                <!-- Modal -->
                                <div id="procesoModal-{{ $video->id }}" tabindex="-1"
                                    class="fixed inset-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto bg-gray-800 bg-opacity-25 items-center justify-center">
                                    <div class="relative max-w-xl max-h-full w-full">
                                        <!-- Modal content -->
                                        <div
                                            class="relative bg-white max-w-2xl w-full max-h-[100vh] overflow-y-auto rounded-lg shadow">
                                            <!-- Modal header -->
                                            <div
                                                class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                                                <h3 class="text-xl font-medium text-gray-900">
                                                    Público objetivo
                                                </h3>
                                                <button type="button"
                                                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                                                    data-modal-hide="procesoModal-{{ $video->id }}">
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
                                                    {{ $video->publico_objetivo }}
                                                </p>
                                            </div>

                                            <!-- Modal footer -->
                                            <div
                                                class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b">
                                                <button data-modal-hide="procesoModal-{{ $video->id }}"
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
                            <div class="p-4 rounded-md shadow-sm">
                                <h2 class="text-2xl font-medium mb-4">Datos del Innovador</h2>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-700">
                                    <div>
                                        <p><strong>Nombre:</strong> {{ $video->innovador }}</p>
                                        <p class="whitespace-nowrap truncate max-w-xs"><strong>Correo: </strong><a
                                                class="text-blue-600 hover:underline "
                                                href= "mailto:{{ $video->email }}">{{ $video->email }}</a>
                                        </p>
                                    </div>
                                    <div>
                                        @if (!empty($video->institucion_educativa))
                                            <p><strong>Colegio:</strong> {{ $video->institucion_educativa }}</p>
                                        @endif
                                    </div>
                                    <div>
                                        @if (!empty($video->departamento))
                                            <p><strong>Departamento:</strong> {{ $video->departamento }}</p>
                                        @endif
                                        @if (!empty($video->ciudad))
                                            <p><strong>Ciudad:</strong> {{ $video->ciudad }}</p>
                                        @endif

                                    </div>
                                    <div>
                                        @if (!empty($video->coautor))
                                            <p><strong>Coautor(es):</strong> {{ $video->coautor }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            @if ($video->extra_puntos)
                                <!-- Extra puntos -->
                                <div class="p-2 rounded-md shadow-sm">
                                    <div class="grid grid-cols-1 gap-4 text-gray-700">
                                        <div>
                                            <p>
                                                <span class="text-green-600">Innovación con +10 puntos extra</span> por
                                                inscribirse <b>antes</b> del primer cierre.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    @if (auth()->check() && (auth()->user()->rol == 'superadmin' || auth()->user()->rol == 'evaluador'))
                        <!-- Formulario de Evaluación -->
                        <div class="container mx-auto my-4 py-6 px-6 bg-white rounded-lg">

                            <!-- Formulario de Evaluación -->
                            <form action="{{ route('videos.update', $video->id) }}" method="POST"
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
                                        class="border border-gray-300 p-2 w-full rounded-md">{{ old('comentario', $comentarioEvaluacion->comentario ?? '') }}</textarea>
                                </div>


                                <!-- Botón Guardar -->
                                <div class="text-center mb-6">
                                    @if (auth()->check() && (auth()->user()->rol == 'superadmin' || auth()->user()->rol == 'evaluador'))
                                        <button type="submit"
                                            class="text-white bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 font-medium rounded-lg text-lg px-5 py-2.5 text-center">
                                            Guardar Evaluación
                                        </button>
                                    @endif
                                </div>
                            </form>
                        </div>
                    @endif
                </div>
                {{-- Contenido --}}

                <div class="h-10">
                </div>

                @php
                    // ID actual de la innovación (puede venir del modelo o de la ruta)
                    $currentId = $video->id;

                    // Buscar el siguiente ID mayor que el actual (para el botón de "Siguiente")
                    $nextInnovation = \App\Models\Video::where('id', '>', $currentId)->orderBy('id', 'asc')->first();

                    // Buscar el anterior ID menor que el actual (para el botón de "Anterior")
                    $prevInnovation = \App\Models\Video::where('id', '<', $currentId)->orderBy('id', 'desc')->first();

                    // Buscar el primer y último ID existente
                    $firstInnovation = \App\Models\Video::orderBy('id', 'asc')->first();
                    $lastInnovation = \App\Models\Video::orderBy('id', 'desc')->first();

                    // Lógica para el botón "Siguiente"
                    if ($nextInnovation) {
                        $nextUrl = '/videos/' . $nextInnovation->id . '/edit';
                        $buttonText = 'Siguiente';
                    } else {
                        $nextUrl = '/videos/' . $firstInnovation->id . '/edit';
                        $buttonText = 'Volver al inicio';
                    }

                    // Lógica para el botón "Anterior"
                    if ($prevInnovation) {
                        $prevUrl = '/videos/' . $prevInnovation->id . '/edit';
                        $prevButtonText = 'Anterior';
                    } else {
                        $prevUrl = '/videos/' . $lastInnovation->id . '/edit';
                        $prevButtonText = 'Ir al último';
                    }
                @endphp

                <div class=""
                    style="position: fixed; bottom: 0; left: 0; width: 100%; background-color: #f8f9fa; padding: 15px; border-top: 2px solid #e0e0e0; z-index: 1000; display: flex; justify-content: space-between; align-items: center;">

                    <a href="{{ $prevUrl }}"
                        class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-md text-sm p-2 text-center">
                        <i class="fa-solid fa-chevron-left"></i>
                        {{ $prevButtonText }}
                    </a>

                    <a href="{{ $nextUrl }}"
                        class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-md text-sm p-2 text-center">
                        {{ $buttonText }}
                        <i class="fa-solid fa-chevron-right"></i>
                    </a>
                </div>
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

<script>
    function openModal(userId) {
        // Obtener todas las evaluaciones como un array
        let evaluacionesPorUsuario = @json($detalleevaluaciones);
        let comentariosPorUsuario = @json($comentarios); // Comentarios generales

        // Obtener las evaluaciones del usuario seleccionado
        let evaluaciones = evaluacionesPorUsuario[userId] || [];

        // Obtener el modal y elementos donde mostrar la información
        let modal = document.getElementById('modal-evaluacion');
        let detalleEvaluacionDiv = document.getElementById('detalle-evaluacion');
        let evaluadorNombre = document.getElementById('evaluador-nombre');

        // Limpiar cualquier contenido anterior
        detalleEvaluacionDiv.innerHTML = '';

        if (evaluaciones.length > 0) {
            // Mostrar el nombre del evaluador
            evaluadorNombre.textContent = "Evaluador - " + evaluaciones[0].user.name;

            // Crear una tabla
            let table = document.createElement('table');
            table.classList.add('w-full', 'table-auto', 'border-collapse', 'border', 'border-gray-300');

            // Crear el encabezado de la tabla
            let thead = document.createElement('thead');
            thead.innerHTML = `
            <tr class="bg-gray-100">
                <th class="px-4 py-2 border">Criterio</th>
                <th class="px-4 py-2 border">Puntaje</th>
                <th class="px-4 py-2 border">Comentario</th>
            </tr>
        `;
            table.appendChild(thead);

            // Crear el cuerpo de la tabla
            let tbody = document.createElement('tbody');

            // Variable para calcular la suma total de los puntajes
            let totalPuntaje = 0;

            // Recorrer las evaluaciones para llenar las filas
            evaluaciones.forEach(evaluacion => {
                let criterioNombre = evaluacion.criterio.name;
                let puntaje = evaluacion.puntaje;
                let comentario = evaluacion.comentario || 'Sin comentario';

                // Sumar el puntaje
                totalPuntaje += puntaje;

                // Crear una fila por cada evaluación
                let tr = document.createElement('tr');
                tr.innerHTML = `
                <td class="px-4 py-2 border">${criterioNombre}</td>
                <td class="px-4 py-2 border text-center">${puntaje}</td>
                <td class="px-4 py-2 border">${comentario}</td>
            `;
                tbody.appendChild(tr);
            });

            // Agregar una fila final para mostrar el total de puntajes
            let trTotal = document.createElement('tr');
            trTotal.innerHTML = `
            <td class="px-4 py-2 border font-bold text-right" colspan="1">Total Puntaje</td>
            <td class="px-4 py-2 border text-center font-bold">${totalPuntaje}</td>
        `;
            tbody.appendChild(trTotal);

            // Añadir el cuerpo a la tabla
            table.appendChild(tbody);

            // Agregar la tabla al div `detalle-evaluacion`
            detalleEvaluacionDiv.appendChild(table);

            // Mostrar el comentario general del evaluador
            let comentarioGeneral = comentariosPorUsuario[userId] ? comentariosPorUsuario[userId].comentario :
                'Sin comentario';
            let comentarioDiv = document.createElement('div');
            comentarioDiv.classList.add('mt-4', 'p-4', 'bg-gray-100', 'border', 'border-gray-300', 'rounded');
            comentarioDiv.innerHTML = `<strong>Comentario general:</strong> ${comentarioGeneral}`;
            detalleEvaluacionDiv.appendChild(comentarioDiv);
        } else {
            detalleEvaluacionDiv.innerHTML = '<p>No hay detalles disponibles para esta evaluación.</p>';
        }

        // Mostrar el modal
        modal.classList.remove('hidden');
    }
</script>

</html>
