<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta id="viewport" name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="cache-control" content="no-cache, no-store, must-revalidate"/>
        <meta http-equiv="expires" content="0" />
        <meta http-equiv="pragma" content="no-cache" />

        <link rel="apple-touch-icon" sizes="76x76" href="/images/favicon/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/images/favicon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/images/favicon/favicon-16x16.png">
        <link rel="manifest" href="/images/favicon/site.webmanifest">
        <link rel="mask-icon" href="/images/favicon/safari-pinned-tab.svg" color="#5bbad5">
        <meta name="msapplication-TileColor" content="#da532c">
        <meta name="theme-color" content="#ffffff">

        <title>{{ config('app.name') }}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600|Roboto|Nunito:200,300,400,600,700,800,900" rel="stylesheet" type="text/css">
        <link href="{{ (env('APP_ENV') === 'local') ? mix('css/app.css') : asset('css/app.css') }}" rel="stylesheet" />
    </head>
    <body>
        <div id="app">
            {{-- <router-view></router-view> --}}
        </div>
        <script async defer src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_MAPS_API')}}"></script>
        <script src="{{ (env('APP_ENV') === 'local') ? mix('js/manifest.js?v=1.1') : asset('js/manifest.js') }}" defer></script>
        <script src="{{ (env('APP_ENV') === 'local') ? mix('js/vendor.js?v=1.1') : asset('js/vendor.js') }}" defer></script>
        <script src="{{ (env('APP_ENV') === 'local') ? mix('js/app.js?v=1.1') : asset('js/app.js') }}" defer></script>
    </body>
</html>
