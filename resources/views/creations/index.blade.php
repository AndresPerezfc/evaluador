@props(['breadcrumb' => []])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Co-creemos</title>

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



    <nav style="background: linear-gradient(75deg, #FF8957 23%, #FF5F69 100%);"  class="fixed top-0 z-50 w-full border-b border-gray-200">
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
                        Co-creemos
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
                'route' => '#'
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
                                                    class="flex items-center w-full p-2 text-gray-900 rounded-lg group {{ $item['active'] ? 'bg-gray-100' : '' }}">

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
                                    class="flex items-center p-2 text-gray-900 rounded-lg group {{ $link['active'] ? 'bg-gray-100' : '' }}">
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

        <div class="mt-24">
            <div class="py-8 px-16 border-2 border-gray-200 border-dashed rounded-lg">

                @if (session('success'))
                    <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                @endif

                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    #
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    <a href="{{ route('creations.index', ['sort_by' => 'titulo', 'sort_direction' => $sortDirection === 'asc' ? 'desc' : 'asc']) }}">
                                        Título
                                        @if($sortBy == 'titulo')
                                            @if($sortDirection == 'asc')
                                                <i class="fa-solid fa-arrow-up"></i>
                                            @else
                                                <i class="fa-solid fa-arrow-down"></i>
                                            @endif
                                        @endif
                                    </a>
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    <a href="{{ route('creations.index', ['sort_by' => 'cocreador', 'sort_direction' => $sortDirection === 'asc' ? 'desc' : 'asc']) }}">
                                        Creador
                                        @if($sortBy == 'cocreador')
                                            @if($sortDirection == 'asc')
                                                <i class="fa-solid fa-arrow-up"></i>
                                            @else
                                                <i class="fa-solid fa-arrow-down"></i>
                                            @endif
                                        @endif
                                    </a>
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    <a href="{{ route('creations.index', ['sort_by' => 'rol_autor', 'sort_direction' => $sortDirection === 'asc' ? 'desc' : 'asc']) }}">
                                        Rol
                                        @if($sortBy == 'rol_autor')
                                            @if($sortDirection == 'asc')
                                                <i class="fa-solid fa-arrow-up"></i>
                                            @else
                                                <i class="fa-solid fa-arrow-down"></i>
                                            @endif
                                        @endif
                                    </a>
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    <a href="{{ route('creations.index', ['sort_by' => 'puntaje', 'sort_direction' => $sortDirection === 'asc' ? 'desc' : 'asc']) }}">
                                        Puntaje
                                        @if($sortBy == 'puntaje')
                                            @if($sortDirection == 'asc')
                                                <i class="fa-solid fa-arrow-up"></i>
                                            @else
                                                <i class="fa-solid fa-arrow-down"></i>
                                            @endif
                                        @endif
                                    </a>
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    <div class="flex items-center">
                                        Calificaciones
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    <div class="flex items-center">
                                        Evaluado
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    <div class="flex items-center">
                                        Extra Puntos
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    <span class="sr-only">Edit</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($creations as $creation)
                                <tr class="even:bg-gray-100 odd:bg-white border-b cursor-pointer hover:bg-gray-200"
                                    data-url="{{ route('creations.edit', $creation->id) }}">
                                    <th scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap truncate max-w-xs">
                                        {{ $loop->index + 1 }}
                                    </th>
                                    <th scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap truncate max-w-xs">
                                        {{ $creation->titulo }}
                                    </th>
                                    <td scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap truncate max-w-xs">
                                        {{ $creation->cocreador }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $creation->rol_autor }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($creation->evaluado_por_usuario_actual || (auth()->check() && (auth()->user()->rol == 'superadmin')))
                                        {{ number_format($creation->puntaje, 1) }}
                                        @else
                                        <span style="filter:blur(3px)">99</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 items-center">
                                        {{ $creation->evaluaciones_por_usuario }}/3
                                    </td>
                                    <td class="px-6 py-4 items-center">
                                        @if ($creation->evaluado_por_usuario_actual)
                                        <i class="fa-regular fa-circle-check text-green-500 text-center"></i>
                                        @else
                                        <i class="fa-solid fa-circle-exclamation text-yellow-300"></i>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        @if ($creation->extra_puntos)
                                        <i class="fa-solid fa-check text-green-500"></i>
                                        @else
                                        <i class="fa-solid fa-x" style="color: #d05353;"></i>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('creations.edit', $creation->id) }}">Evaluar</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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
    document.addEventListener('DOMContentLoaded', function() {
        // Selecciona todas las filas de la tabla
        document.querySelectorAll('tr.cursor-pointer').forEach(function(row) {
            row.addEventListener('click', function() {
                // Obtén la URL del atributo data-url
                var url = this.getAttribute('data-url');
                // Redirige a la URL
                window.location.href = url;
            });
        });
    });
</script>

</html>
