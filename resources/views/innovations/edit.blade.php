@props(['breadcrumb' => []])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Tus Innovaciones</title>

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

    <nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200">
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
                    <a href="https://flowbite.com" class="flex ms-2 md:me-24">
                        <img src="https://flowbite.com/docs/images/logo.svg" class="h-8 me-3" alt="FlowBite Logo" />
                        <span
                            class="self-center text-xl font-semibold sm:text-2xl whitespace-nowrap">Flowbite</span>
                    </a>
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
                'name' => 'Tus Innovaciones',
                'icon' => 'fa-solid fa-gauge',
                'route' => '#',
                'active' => true,
            ],

            [
                'name' => 'Mejor video educativo',
                'icon' => 'fa-solid fa-users',
                'route' => '',
                'active' => false,
            ],

            [
                'name' => 'Co-creemos',
                'icon' => 'fa-solid fa-building',
                'active' => false,
                'submenu' => [
                    [
                        'name' => 'información',
                        'icon' => 'fa-regular fa-circle',
                        'route' => '',
                        'active' => false,
                    ],
                    [
                        'name' => 'información',
                        'icon' => 'fa-regular fa-circle',
                        'route' => '',
                        'active' => false,
                    ],
                ],
            ],
        ];
    @endphp

    <aside id="logo-sidebar"
        class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0 "
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
            <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg">
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">


                    {{-- Contenido --}}

                    <h1>Evaluar Innovación: {{ $innovation->name }}</h1>

    <form action="{{ route('innovations.update', $innovation->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label for="criterio1">Criterio 1 (40 puntos):</label>
            <input type="number" name="criterio1" id="criterio1" min="0" max="40" required>
        </div>

        <div>
            <label for="criterio2">Criterio 2 (20 puntos):</label>
            <input type="number" name="criterio2" id="criterio2" min="0" max="20" required>
        </div>

        <div>
            <label for="criterio3">Criterio 3 (20 puntos):</label>
            <input type="number" name="criterio3" id="criterio3" min="0" max="20" required>
        </div>

        <div>
            <label for="criterio4">Criterio 4 (10 puntos):</label>
            <input type="number" name="criterio4" id="criterio4" min="0" max="10" required>
        </div>

        <div>
            <label for="criterio5">Criterio 5 (10 puntos):</label>
            <input type="number" name="criterio5" id="criterio5" min="0" max="10" required>
        </div>

        <button type="submit">Guardar Evaluación</button>
    </form>
                        
                    {{-- Contenido --}}


                </div>
            </div>
        </div>
    </div>


    <div x-cloak x-show="open" x-on:click="open = false"
        class="bg-gray-900 bg-opacity-50 fixed inset-0 z-30 sm:hidden"></div>

    @stack('modals')

    @livewireScripts
</body>

</html>
