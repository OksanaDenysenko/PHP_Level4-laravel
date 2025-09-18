<!DOCTYPE html>
<html>
<head>
    <title>Star Wars</title>
@vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<div id="app">
    <people-page></people-page>
</div>
<script>
    // Створюємо глобальну змінну, доступну для Vue
    window.initialPeople = @json($people);
</script>
</body>
</html>
