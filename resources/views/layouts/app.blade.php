<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            .sidebar-link.active {
                background-color: #3b82f6;
                color: white;
            }
        </style>
    </head>
    <body class="font-sans antialiased bg-gray-100">
        <div class="flex h-screen overflow-hidden">
            <!-- Sidebar -->
            <aside id="sidebar" class="w-64 bg-gray-800 text-white flex-shrink-0 overflow-y-auto transition-all duration-300">
                <!-- Logo/Header -->
                <div class="p-4 bg-gray-900">
                    <h1 class="text-xl font-bold text-center">Supervisión de Enfermería</h1>
                    <p class="text-xs text-gray-400 text-center mt-1">Gestión de Pacientes</p>
                </div>

                <!-- User Info -->
                <div class="p-4 bg-gray-700 border-b border-gray-600">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-blue-500 flex items-center justify-center text-white font-bold">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold truncate">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-gray-400 capitalize">{{ auth()->user()->rol }}</p>
                        </div>
                    </div>
                </div>

                <!-- Navigation -->
                <nav class="p-4 space-y-2">
                    <!-- Dashboard -->
                    <a href="{{ route('dashboard') }}" 
                        class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-700 transition {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        <span>Dashboard</span>
                    </a>

                    <!-- Registro de Paciente -->
                    <a href="{{ route('paciente.registro') }}" 
                        class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-700 transition {{ request()->routeIs('paciente.registro') ? 'active' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                        </svg>
                        <span>Nuevo Paciente</span>
                    </a>

                    <!-- Divider -->
                    <div class="border-t border-gray-600 my-4"></div>

                    <!-- Section: Gestión -->
                    <div class="px-4 py-2">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Gestión</p>
                    </div>

                    <!-- Gestión de Pacientes -->
                    <a href="{{ route('pacientes.gestion') }}" 
                        class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-700 transition {{ request()->routeIs('pacientes.gestion') ? 'active' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        <span>Gestión de Pacientes</span>
                    </a>

                    @can('supervisora')
                    <!-- Divider -->
                    <div class="border-t border-gray-600 my-4"></div>

                    <!-- Section: Supervisión -->
                    <div class="px-4 py-2">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Supervisión</p>
                    </div>

                    <!-- Verificaciones Pendientes -->
                    <a href="{{ route('dashboard') }}#verificaciones" 
                        class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-700 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                        </svg>
                        <span>Verificaciones</span>
                    </a>
                    @endcan

                    <!-- Divider -->
                    <div class="border-t border-gray-600 my-4"></div>

                    <!-- Section: Reportes -->
                    <div class="px-4 py-2">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Reportes</p>
                    </div>

                    <!-- Generar Reportes -->
                    <a href="{{ route('reportes.index') }}" 
                        class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-700 transition {{ request()->routeIs('reportes.index') ? 'active' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <span>Generar Reportes</span>
                    </a>

                    <!-- Divider -->
                    <div class="border-t border-gray-600 my-4"></div>

                    <!-- Logout -->
                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
                        class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-red-600 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        <span>Cerrar Sesión</span>
                    </a>
                    <form id="logout-form" action="/logout" method="POST" style="display: none;">
                        @csrf
                    </form>
                </nav>

                <!-- Toggle Button (Mobile) -->
                <button id="sidebar-toggle" class="lg:hidden fixed bottom-4 right-4 bg-blue-600 text-white p-3 rounded-full shadow-lg z-50">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </aside>

            <!-- Main Content -->
            <div class="flex-1 flex flex-col overflow-hidden">
                <!-- Top Bar -->
                <header class="bg-white shadow-sm z-10">
                    <div class="px-6 py-4">
                        @if (isset($header))
                            {{ $header }}
                        @else
                            <h2 class="text-2xl font-bold text-gray-800">
                                @yield('title', 'Dashboard')
                            </h2>
                        @endif
                    </div>
                </header>

                <!-- Page Content -->
                <main class="flex-1 overflow-y-auto bg-gray-50 p-6">
                    {{ $slot }}
                </main>
            </div>
        </div>

        <!-- Mobile Sidebar Toggle Script -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const sidebar = document.getElementById('sidebar');
                const toggleBtn = document.getElementById('sidebar-toggle');
                
                if (toggleBtn) {
                    toggleBtn.addEventListener('click', function() {
                        sidebar.classList.toggle('-translate-x-full');
                    });
                }

                // Close sidebar when clicking outside on mobile
                document.addEventListener('click', function(event) {
                    if (window.innerWidth < 1024) {
                        if (!sidebar.contains(event.target) && !toggleBtn.contains(event.target)) {
                            sidebar.classList.add('-translate-x-full');
                        }
                    }
                });
            });
        </script>
    </body>
</html>
