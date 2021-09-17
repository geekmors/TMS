    @include('inc.head')
    <body>
        @include('inc.header')
        <div class="container">
            @yield('content')
        </div>
        @include('inc.footer')
    </body>
</html>