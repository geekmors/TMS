    @include('inc.head')
    <body>
        @include('inc.messages')
        @include('inc.header')
        <div class="mt-5">
            @yield('content')
        </div>
        @include('inc.footer')
    </body>
</html>