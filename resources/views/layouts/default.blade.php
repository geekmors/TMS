    @include('inc.head')
    <body>
        @include('inc.messages')
        @include('inc.header')
        <div class="container">
            @yield('content')
        </div>
        @include('inc.footer')
    </body>
</html>