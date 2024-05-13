<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="shortcut icon" href="https://galajaya.com/favicon.ico" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800&amp;display=swap"
        rel="stylesheet">

    <title>{{ $title ?? 'Gala Jaya Group' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="font-poppins">
    @livewire('partials.navbar')
    <main>{{ $slot }}</main>
    @livewire('partials.footer')
    @livewireScripts
</body>

</html>
