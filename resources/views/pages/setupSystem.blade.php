@extends('layouts.default')

@section('content')
<h1>Setup Time Management System</h1>
<p>{{$path}}</p>
<a href="{{route('googleAuth')}}">Start by signing in with google</a>
@endsection