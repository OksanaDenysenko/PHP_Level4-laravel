<!DOCTYPE html>
<html>
<head>
    <title>Star Wars</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<div id="app">
    <people-page></people-page>
</div>
</body>
</html>
