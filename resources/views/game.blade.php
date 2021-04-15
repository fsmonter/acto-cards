<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>{{ config('app.name') }}</title>
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link href="{{mix('css/app.css')}}" rel="stylesheet">
        <script src="{{mix('js/app.js')}}" defer></script>
    </head>
    <body class="antialiased bg-gray-100">
        <div id="app" class="flex flex-col justify-center h-screen sm:mx-auto sm:max-w-3xl">
            <game class="w-full"/></game>
            <leaderboard class="w-full"></leaderboard>
        </div>
    </body>
</html>
