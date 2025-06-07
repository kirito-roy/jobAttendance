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
        <nav class="bg-gray-800 w-svw">
            <div class="w-full px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <!-- Left Logo + Nav -->
                    <div class="flex items-center">
                        <img class="h-8 shrink-0"
                            src="https://www.presentations.gov.in/wp-content/uploads/2020/06/ICONIC_SQUARE_NIC_Logo_blue-01.png"
                            alt="Logo">

                        <!-- Desktop Navigation -->
                        <div class="hidden ml-10 md:block">
                            <div class="flex items-baseline space-x-4">
                                @php
                                    $roles = Auth::user()->roles->pluck('role')->toArray();
                                @endphp

                                @if (in_array('user', $roles))
                                    <x-navigate href="/">home</x-navigate>
                                    <x-navigate href="/attendance">attendance</x-navigate>
                                @endif

                                @if (in_array('admin', $roles))
                                    <x-navigate href="/admin">Admin Panel</x-navigate>
                                    <x-navigate href="/role">Roles</x-navigate>
                                    <x-navigate href="/schedule">Schedule</x-navigate>
                                @endif

                                @if (in_array('manager', $roles))
                                    <x-navigate href="/manager">Manager Panel</x-navigate>
                                @endif

                                <x-navigate href="/profile">profile</x-navigate>
                                <x-navigate href="/about">about</x-navigate>

                            </div>
                        </div>
                    </div>

                    <!-- Desktop User Info -->
                    <div class="items-center hidden space-x-4 text-white md:flex">
                        <span>{{ Auth::user()->name }}</span>

                        @auth
                            <form action="/logout" method="POST">
                                @csrf
                                <button type="submit"
                                    class="px-3 py-2 text-gray-300 rounded-md hover:bg-gray-700 hover:text-white">
                                    LOGOUT
                                </button>
                            </form>
                        @else
                            <x-navigate href="/login">login</x-navigate>
                        @endauth

                        <a href="/notification" class="relative">
                            <button type="button"
                                class="p-1 text-gray-400 bg-gray-800 rounded-full hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                    stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75A8.967 8.967 0 0 1 3.688 15.772c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
                                </svg>
                            </button>
                        </a>
                    </div>

                    <!-- Mobile Menu Button -->
                    <div class="flex md:hidden">
                        <button type="button" aria-controls="mobile-menu" aria-expanded="false"
                            class="relative inline-flex items-center justify-center p-2 text-gray-400 bg-gray-800 rounded-md mobile-toggle-btn hover:bg-gray-700 hover:text-white focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800">
                            <svg class="w-6 h-6 menu-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                            </svg>
                            <svg class="hidden w-6 h-6 close-icon" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div class="hidden md:hidden" id="mobile-menu">
                <div class="px-4 pt-2 pb-3 space-y-1 text-center text-white">
                    @php
                        $roles = Auth::user()->roles->pluck('role')->toArray();
                    @endphp

                    @if (in_array('user', $roles))
                        <x-navigate href="/">home</x-navigate>
                        <x-navigate href="/attendance">attendance</x-navigate>
                    @endif

                    @if (in_array('admin', $roles))
                        <x-navigate href="/admin">Admin Panel</x-navigate>
                        <x-navigate href="/role">Roles</x-navigate>
                        <x-navigate href="/schedule">Schedule</x-navigate>
                    @endif

                    @if (in_array('manager', $roles))
                        <x-navigate href="/manager">Manager Panel</x-navigate>
                    @endif

                    <x-navigate href="/profile">profile</x-navigate>
                    <x-navigate href="/about">about</x-navigate>

                </div>

                <div class="flex items-center justify-between px-4 pt-4 pb-3 text-white border-t border-gray-700">
                    <span>{{ Auth::user()->name }}</span>
                    <form action="/logout" method="POST">
                        @csrf
                        <button type="submit"
                            class="px-3 py-2 text-gray-300 rounded-md hover:bg-gray-700 hover:text-white">LOGOUT</button>
                    </form>
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
