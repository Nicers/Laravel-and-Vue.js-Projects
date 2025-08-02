<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <x-front-header-css></x-front-header-css>
</head>

<body>
    <div id="app">
        <x-front-header-html></x-front-header-html>

        <main class="py-4">
            @yield('content')
        </main>

        <x-front-footer-html></x-front-footer-html>
    </div>

    <x-front-footer-js></x-front-footer-js>
</body>

</html>