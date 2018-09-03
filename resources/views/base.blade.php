<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <title>Full-stack party github issue tracker</title>
    <link rel="stylesheet" type="text/css" href="/css/app.css"/>
    <script src="/js/bootleg.js"></script>
</head>
<body>
    @include('includes.top_header')
    @yield('content')
</body>
</html>
