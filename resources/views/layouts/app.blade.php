<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- FavIcon -->
    <link rel="icon" href="{{ asset('clapperboard.ico') }}" type="image/x-icon">

    <title>{{ config('app.name', 'Laravel') }}</title>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Scripts -->
    @vite([
        'resources/css/app.css',
        'resources/css/datatables/datatables.custom.css',
        'resources/css/globalcss/globalcss.css',
        'resources/js/app.js'
    ])
    
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <strong><a class="navbar-brand" href="{{ url('/') }}"> {{ config('app.name', 'Laravel') }} </a></strong>
            </div>
        </nav>
        
        <main class="pt-4">
            @yield('content')
        </main>
        
        @hasSection ('footer')
            @yield('footer')
        @endif
    </div>
</body>
</html>
