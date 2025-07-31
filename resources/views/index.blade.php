<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://telegram.org/js/telegram-web-app.js"></script>

        <title>Laravel</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @vite('resources/css/app.css')
    </head>
    <body>
        <div id="app"></div>
        <script type="module" src="{{ Vite::asset('resources/js/app.js') }}"></script>

        <!-- Console (Для ТГ МИНИАПП) -->
        <script src="https://cdn.jsdelivr.net/npm/eruda"></script>
        <script>eruda.init();</script>
    </body>
</html>
