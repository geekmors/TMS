    @include('inc.head')
    <body>
        @include('inc.messages')
        <div class="container">
        <div class="logo" >
            <img class="img-fluid" src="https://i1.wp.com/koopsheet.com/wp-content/uploads/2021/05/KSM-Logo-2021-Complete.png?resize=768%2C203&ssl=1" alt="Company Logo">
            
        </div>
            @yield('content')
        </div>
    </body>
</html>