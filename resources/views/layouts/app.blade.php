<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Bimbel Privat')</title>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    @stack('styles')
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        @include('components.sidebar')

        <main class="main-content">
            <!-- Header -->
            @include('components.header')

            <div class="content">
                @yield('content')
            </div>
        </main>
    </div>

    @stack('scripts')
</body>
</html>