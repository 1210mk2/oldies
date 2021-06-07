<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Oldies but goldies demo</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style>
    </head>
    <body>
    <div style="text-align: center">
        <p>Your api authorization token: {{ env('API_KEY') }}</p>
        <span>See <a target="_blank" href="/api/documentation">swagger api documentation</a></span>
    </div>
    </body>
</html>
