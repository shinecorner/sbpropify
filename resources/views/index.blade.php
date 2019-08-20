<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="cache-control" content="no-cache, no-store, must-revalidate"/>
        <meta http-equiv="expires" content="0"/>
        <meta http-equiv="pragma" content="no-cache"/>

        <title>{{ config('app.name') }}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600|Roboto" rel="stylesheet" type="text/css">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet"/>

    </head>
    <body>
        <div id="app">
            {{-- <router-view></router-view> --}}
        </div>
        <script src="{{ (env('APP_ENV') === 'local') ? mix('js/manifest.js?v=1.1') : asset('js/manifest.js?v=1.1') }}"></script>
        <script src="{{ (env('APP_ENV') === 'local') ? mix('js/vendor.js?v=1.1') : asset('js/vendor.js?v=1.1') }}"></script>
        <script async defer src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_MAPS_API')}}"></script>
        <script src="{{ (env('APP_ENV') === 'local') ? mix('js/app.js?v=1.1') : asset('js/app.js?v=1.1') }}"></script>
    </body>
</html>
