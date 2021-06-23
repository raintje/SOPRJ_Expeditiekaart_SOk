<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Expeditiekaart - Home</title>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-199335145-2"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-199335145-2');
    </script>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ mix('css/app.css') }}"/>
</head>
<body>
<div>
    <div id="app">
        <app dusk="home-component"></app>
    </div>
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
