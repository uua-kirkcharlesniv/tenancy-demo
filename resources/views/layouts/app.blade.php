<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @if (tenant() == null)
            {{ config('app.name', 'Laravel') }}
        @else
            {{ tenant()->company }}
        @endif
    </title>

    @if (tenant() == null)
    @else
        @if (tenant()->logo == null)
            <link rel="icon" type="image/jpg" href="https://ui-avatars.com/api/?name={{ htmlentities(tenant()->company) }}&background=random">
        @else
            <link rel="icon" type="image/jpg" href="{{ asset(tenant()->logo) }}">
        @endif
    @endif

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/fontawesome.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/all.min.css" />
    <style type="text/css">
        i {
            font-size: 50px !important;
            padding: 10px;
        }
    </style>
    @yield('custom-head')
    @livewireStyles
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>

    @yield('custom-body')
    @livewireScripts
</body>

</html>
