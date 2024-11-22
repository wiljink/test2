<!-- resources/views/layouts/app.blade.php -->

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        <!-- Header with Navigation and Logo -->
        <header class="bg-white shadow">
            <div class="container mx-auto px-4 py-6 flex justify-between items-center">
                <!-- Logo -->
                <div>
                    <a href="{{ url('/') }}">
                        <img src="{{ asset('path-to-your-logo/logo.png') }}" alt="Logo" class="h-10">
                    </a>
                </div>
                <!-- Navigation Menu -->
                <nav class="flex space-x-4">
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-gray-900">Home</a>
                    <a href="{{ route('about') }}" class="text-gray-700 hover:text-gray-900">About</a>
                    <a href="{{ route('contact') }}" class="text-gray-700 hover:text-gray-900">Contact</a>
                    <!-- Add more links as needed -->
                    @auth
                        <!-- Show logout link if authenticated -->
                        <form action="{{ route('logout') }}" method="post">
                            @csrf
                            <button type="submit" class="text-gray-700 hover:text-gray-900">Logout</button>
                        </form>
                    @else
                        <!-- Show login/register links if not authenticated -->
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-gray-900">Login</a>
                        <a href="{{ route('register') }}" class="text-gray-700 hover:text-gray-900">Register</a>
                    @endauth
                </nav>
            </div>
        </header>

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>
</body>
</html>
