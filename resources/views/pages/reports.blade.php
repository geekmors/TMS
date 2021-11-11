@extends('layouts.default')

@section('content')
<div class="ml-5">
    <h1>Reports all</h1>
</div>
@if($isNotEmployee)
    <div class="ml-5">
        <h2>Reports some</h2>
    </div>
@endif
@endsection