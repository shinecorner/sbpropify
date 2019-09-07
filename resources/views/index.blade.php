<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta id="viewport" name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="cache-control" content="no-cache, no-store, must-revalidate"/>
        <meta http-equiv="expires" content="0" />
        <meta http-equiv="pragma" content="no-cache" />

        <link rel="icon" type="image/png" href="/storage/test-estate-1-favicon-icon.png"/>
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
        <script src="{{ (env('APP_ENV') === 'local') ? mix('js/manifest.js') : asset('js/manifest.js') }}" defer></script>
        <script src="{{ (env('APP_ENV') === 'local') ? mix('js/vendor.js') : asset('js/vendor.js') }}" defer></script>
        <script src="{{ (env('APP_ENV') === 'local') ? mix('js/app.js') : asset('js/app.js') }}" defer></script>
    </body>
</html>
