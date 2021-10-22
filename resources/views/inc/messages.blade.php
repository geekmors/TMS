@if($message = Session::get('success'))
    <div id="systemMessages" style="background:green; color:white; position:fixed; width: 30%; top:0; right:0;">
        <p>{{$message}}</p>
    </div>
@endif