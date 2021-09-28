    @include('inc.head')
    <body>
        @include('inc.messages')
        <div class="container">
        <div class="logo" >
            <img style="width:300px" src="{{$logo}}" alt="Company Logo">
            
        </div>
            @yield('content')
        </div>
    </body>
</html>