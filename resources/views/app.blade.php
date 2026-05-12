<!DOCTYPE html>
<html lang="pt-BR">
<head>
    @inertiaHead
    @vite(['resources/css/app.css', 'resources/js/app.js'])  
</head>
<body>
    <audio id="audio">
        <source src="/api/cast" type="audio/mpeg">
    </audio>
    @inertia
</body>
