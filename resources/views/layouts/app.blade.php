<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aylo</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">

    @stack('css')
</head>

<body>
<div id="app">
    <main class="py-4">
        @yield('content')
    </main>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

@stack('scripts')

</body>
</html>
