<!DOCTYPE html>
<html lang="pt-BR">
<head>
    @inertiaHead
    @vite(['public/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/quill-editor.css') }}">
</head>
<body>
    <audio id="audio">
        <source src="/api/cast" type="audio/mpeg">
    </audio>
    @inertia
</body>
