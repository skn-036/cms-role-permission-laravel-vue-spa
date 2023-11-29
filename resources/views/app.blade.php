<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>Laravel vue role permission management</title>

    @vite('resources/js/app.js')
</head>

<body class="box-border p-0 m-0 bg-light-bg text-light-color dark:bg-dark-bg dark:text-dark-color font-lora italic">
    <noscript>
        <strong>Please enable javascript otherwise this website will not work</strong>
    </noscript>

    <div id="app"></div>
</body>

</html>
