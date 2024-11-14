<!DOCTYPE html>
<html>
<head>
    @include('layouts.head')
</head>
<body>
    @include('layouts.header')
    <main>
        @yield('content')
    </main>

    @include('layouts.footer')
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>