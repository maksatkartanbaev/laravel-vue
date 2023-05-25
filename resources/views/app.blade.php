<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Domains</title>

@vite(['resources/css/app.css', 'resources/js/app.js'])

<body class="hold-transition sidebar-mini">
<div class="wrapper" id="app">
    <div class="content-wrapper">
        <router-view></router-view>

    </div>

</div>
</body>
</html>
