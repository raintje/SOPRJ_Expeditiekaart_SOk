<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        #container {
            width: 100px;
            height: 100px;
            position: relative;
        }

        #navi,
        #infoi {
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0;
            left: 0;
        }

        #infoi {
            z-index: 10;
        }
    </style>

    <link rel="stylesheet" href="{{ mix('css/app.css') }}"/>
</head>
<body>
<div id="app">
    <edit-location dusk="editLocation-component"></edit-location>
</div>
<script>
    window.Laravel = {!! json_encode([
	'csrfToken' => csrf_token(),
	'baseUrl' => url('/'),
	'routes' => collect(\Route::getRoutes())->mapWithKeys(function ($route) { return [$route->getName() => $route->uri()]; })
]) !!};
</script>
<script src="{{ mix('js/app.js') }}"></script>
</body>
</html>

