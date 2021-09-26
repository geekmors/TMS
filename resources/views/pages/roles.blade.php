@extends('layouts.default')

@section('content')
<h2>roles</h2>
@foreach($roles as $role)
    <p>{{$role->description}} </p>
@endforeach
@endsection
