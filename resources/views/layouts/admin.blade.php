<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - Admin</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .min-h-screen-minus-header {
            min-height: calc(100vh - 4rem); /* tinggi navbar 4rem */
        }
    </style>

    @stack('styles')
</head>

<body class="bg-gray-100 font-sans antialiased">

    <!-- Navbar -->
    <header class="bg-white shadow-md sticky top-0 z-20 h-16 flex items-center">
        <div class="max-w-full w-full px-8 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-900">Admin Panel</h1>

            <div class="flex items-center space-x-4">
                <button class="text-gray-500 hover:text-blue-600 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                </button>

                <div class="h-10 w-10 rounded-full bg-blue-600 flex items-center justify-center text-white font-semibold">
                    AD
                </div>
            </div>
        </div>
    </header>

    <div class="flex">

        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-xl min-h-screen-minus-header sticky top-16 z-10 p-4 pt-8">
            <nav class="space-y-2">

                <!-- Dashboard -->
                <a href="{{ route('dashboard') }}"
                   class="flex items-center px-4 py-2 text-sm rounded-lg transition duration-150
                   {{ ($active_menu ?? '') === 'dashboard' ? 'bg-blue-600 text-white shadow' : 'text-gray-700 hover:bg-gray-100 hover:text-blue-600' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-10v10a1 1 0 001 1h3m-9-6h2m-2 0h2m-2 0h2"/>
                    </svg>
                    Dashboard
                </a>

                <!-- Daftar Artikel -->
                <a href="{{ route('list_article') }}"
                   class="flex items-center px-4 py-2 text-sm rounded-lg transition 
                   {{ ($active_menu ?? '') === 'article' ? 'bg-blue-600 text-white shadow' : 'text-gray-700 hover:bg-gray-100 hover:text-blue-600' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 0h2a2 2 0 012 2v10a2 2 0 01-2 2h-4m-12-6a4 4 0 110-8 4 4 0 010 8z"/>
                    </svg>
                    Daftar Artikel
                </a>

                <!-- Pengguna -->
                <a href="#"
                   class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-blue-600 rounded-lg transition">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20h-5v-2a3 3 0 00-5.356-1.857M9 20l-5-5-5-5m9-5a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    Pengguna
                </a>

            </nav>

            <!-- Logout -->
            <div class="mt-16 pt-4 border-t">
                <a href="#"
                   class="flex items-center px-4 py-2 text-sm font-medium text-red-600 hover:bg-red-50 rounded-lg transition">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Logout
                </a>
            </div>
        </aside>

        <!-- Main -->
        <main class="flex-1 p-8">
            @yield('content')
        </main>
    </div>

    @stack('scripts')

</body>
</html>
