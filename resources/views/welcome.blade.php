<!doctype html>
<html class="no-js" lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <title>Domain-Driven Design (DDD) in Laravel</title>

        <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    </head>
    <body>
        <div id="app"></div>
        
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @viteReactRefresh
            @vite('resources/jsx/app.jsx')
        @endif
    </body>
</html>
