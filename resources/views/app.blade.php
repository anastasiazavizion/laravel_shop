<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        @routes
        @vite(['resources/js/app.js', 'resources/scss/app.scss', 'resources/css/app.css'])
    </head>
    <body class="font-sans antialiased">
    <div id="app"></div>
    <script src="https://www.paypal.com/sdk/js?client-id={{ config('paypal.' . config('paypal.mode') . '.client_id') }}&currency={{ config('paypal.currency') }}"></script>
    </body>
    <script type="text/javascript">
        window.Laravel = {
            jsPermissions: {!! auth()->check() ? auth()->user()->jsPermissions() : 0!!}
        }
    </script>
</html>
