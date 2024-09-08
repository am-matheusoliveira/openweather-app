<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- CSS PADRÃO DA APLICAÇÃO -->
    <link href="{{ config('app.asset_path') }}/build/assets/app-D-sv12UV.css" rel="stylesheet">

    <!-- CSS DO PLUGIN SELEC2 -->
    <link href="{{ config('app.asset_path') }}/build/assets/app-BnsfhC-g.css" rel="stylesheet">

    <!-- Data Tables CSS -->
    <link href="{{ config('app.asset_path') }}/css/datatables.min.css" rel="stylesheet">
    
    <!-- CSS CUSTOMIZADO -->
    <link href="{{ config('app.asset_path') }}/css/custom.css" rel="stylesheet">

    <!-- Scripts -->
    {{-- @vite(['resources/sass/app.scss', 'resources/css/app.css', 'resources/js/app.js']) --}}
    
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <strong><a class="navbar-brand" href="{{ url('/') }}"> {{ config('app.name', 'Laravel') }} </a></strong>
            </div>
        </nav>

        <main class="pt-4"> <!-- py-4 -->
            @yield('content')
        </main>

        <!-- Data Tables JS -->
        <script src="{{ config('app.asset_path') }}/js/datatables.min.js"></script>
        
        <!-- JavaScript PADRÃO DA APLICAÇÃO -->
        <script src="{{ config('app.asset_path') }}/build/assets/app-DkTTh6p2.js"></script>

        <!-- JavaScript CUSTOMIZADO -->
        <script src="{{ config('app.asset_path') }}/js/custom.js"></script>
        
        @hasSection ('footer')
            @yield('footer')
        @endif
    </div>
</body>
</html>
