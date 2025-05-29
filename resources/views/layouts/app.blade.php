<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- FavIcon -->    
    <link rel="icon" href="{{ asset('climate-change.png') }}" type="image/png">

    {{-- System Title --}}
    <title>{{ $title ?? config('app.name') }}</title>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/css/globalcss/globalcss.css', 'resources/js/app.js'])
</head>
<body>
    <div class="container" id="app">
        <main>
            @yield('content')
        </main>
        
        @hasSection ('footer')
            @yield('footer')
        @endif
    </div>
</body>
</html>
