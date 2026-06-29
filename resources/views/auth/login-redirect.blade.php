<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Redirecting...</title>
</head>
<body>
    <h1>Loading...</h1>
    <script>
        // Use replace to overwrite the history entry, so back button doesn't go to login/home
        window.location.replace('{{ $redirectUrl }}');
    </script>
</body>
</html>
