<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ strtoupper($heading) }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="h-full antialiased text-black bg-gray-300 dark:text-white dark:bg-gray-700">


    <div class="flex flex-col h-full">
        <nav class="bg-gray-800 w-svw ">
            <div class="w-full px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <div class="flex items-center">
                        <div class="shrink-0">
                            <img class="h-8"
                                src="https://www.presentations.gov.in/wp-content/uploads/2020/06/ICONIC_SQUARE_NIC_Logo_blue-01.png"
                                alt="Your Company">
                        </div>
                        <div class="hidden md:block ">
                            <div class="flex items-baseline ml-10 space-x-4">
                                <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
                                @if (Auth::user()->role == 'user')
                                    <x-navigate href="/">home</x-navigate>
                                    <x-navigate href="/attendance">attendance</x-navigate>
                                @elseif (Auth::user()->role == 'admin')
                                    <x-navigate href="/admin">Admin
                                        Panel</x-navigate>
                                    <x-navigate href="/role">Roles</x-navigate>
                                    <x-navigate href="/schedule">schedule</x-navigate>
                                @elseif (Auth::user()->role == 'manager')
                                    <x-navigate href="/manager">manager Panel</x-navigate>
                                @endif
                                @if (Auth::user()->role == 'admin' || Auth::user()->role == 'manager')
                                    <x-navigate href="/report">report</x-navigate>
                                @endif
                                <x-navigate href="/profile">profile</x-navigate>



                                <x-navigate href="/about">about</x-navigate>

                            </div>

                        </div>
                    </div>
                    <div class="hidden md:block">

                        <div class="flex items-center ml-4 md:ml-6">
                            <div class="">
                                @if (Auth::check())
                                    <form action="/logout" method="POST" style="display: inline;">
                                        @csrf <!-- Include CSRF token for Laravel -->
                                        <button type="submit"
                                            class="px-3 py-2 font-medium text-gray-300 rounded-md text-l hover:bg-gray-700 hover:text-white ">
                                            LOGOUT
                                        </button>
                                    </form>
                                @else
                                    <x-navigate href="/login">login</x-navigate>
                                @endif

                            </div>
                            <a href="/notification">
                                <button type="button"
                                    class="relative p-1 text-gray-400 bg-gray-800 rounded-full hover:text-white focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800 focus:outline-hidden">
                                    <span class="absolute -inset-1.5"></span>
                                    <span class="sr-only">View notifications</span>
                                    <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                        stroke="currentColor" aria-hidden="true" data-slot="icon">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
                                    </svg>
                                </button>
                            </a>

                            <!-- Profile dropdown -->
                            <div class="relative ml-3">


                            </div>
                        </div>
                    </div>
                    <div class="flex -mr-2 md:hidden">
                        <!-- Mobile menu button -->
                        <button type="button"
                            class="relative inline-flex items-center justify-center p-2 text-gray-400 bg-gray-800 rounded-md hover:bg-gray-700 hover:text-white focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800 focus:outline-hidden"
                            aria-controls="mobile-menu" aria-expanded="false">
                            <span class="absolute -inset-0.5"></span>
                            <span class="sr-only">Open main menu</span>
                            <!-- Menu open: "hidden", Menu closed: "block" -->
                            <svg class="block size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" aria-hidden="true" data-slot="icon">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                            </svg>
                            <!-- Menu open: "block", Menu closed: "hidden" -->
                            <svg class="hidden size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" aria-hidden="true" data-slot="icon">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile menu, show/hide based on menu state. -->
            <div class="hidden md:hidden" id="mobile-menu">
                <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                    <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
                    @if (Auth::user()->role == 'user')
                        <x-navigate href="/" class="block text-white">home</x-navigate>
                        <x-navigate href="/attendance" class="block text-white">attendance</x-navigate>
                    @elseif (Auth::user()->role == 'admin')
                        <x-navigate href="/admin" class="block text-white">Admin
                            Panel</x-navigate>
                        <x-navigate href="/role" class="block text-white">Roles</x-navigate>
                        <x-navigate href="/schedule" class="block text-white">schedule</x-navigate>
                    @elseif (Auth::user()->role == 'manager')
                        <x-navigate href="/manager" class="block text-white">manager Panel</x-navigate>
                    @endif
                    @if (Auth::user()->role == 'admin' || Auth::user()->role == 'manager')
                        <x-navigate href="/report" class="block text-white">report</x-navigate>
                    @endif
                    <x-navigate href="/profile" class="block text-white">profile</x-navigate>



                    <x-navigate href="/about" class="block text-white">about</x-navigate>

                </div>
                <div class="pt-4 pb-3 border-t border-gray-700">
                    <div class="flex items-center px-5">
                        <form action="/logout" method="POST" style="display: inline;">
                            @csrf <!-- Include CSRF token for Laravel -->
                            <button type="submit"
                                class="px-3 py-2 font-medium text-gray-300 rounded-md text-l hover:bg-gray-700 hover:text-white ">
                                LOGOUT
                            </button>
                        </form>
                        <button type="button"
                            class="relative p-1 ml-auto text-gray-400 bg-gray-800 rounded-full shrink-0 hover:text-white focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800 focus:outline-hidden">
                            <span class="absolute -inset-1.5"></span>
                            <span class="sr-only">View notifications</span>
                            <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" aria-hidden="true" data-slot="icon">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
                            </svg>
                        </button>
                    </div>

                </div>
            </div>
        </nav>



        <div class="flex-1 h-full px-4 py-6 mx-4 overflow-auto">
            {{-- <livewire:home /> --}}
            {{ $slot }}
        </div>

    </div>
    <script>
        const mobileMenuButton = document.querySelector('[aria-controls="mobile-menu"]');
        const mobileMenu = document.getElementById('mobile-menu');

        mobileMenuButton.addEventListener('click', () => {
            const isExpanded = mobileMenuButton.getAttribute('aria-expanded') === 'true';
            mobileMenuButton.setAttribute('aria-expanded', !isExpanded);
            mobileMenu.classList.toggle('hidden');
        });
    </script>
</body>

</html>
