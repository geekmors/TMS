@extends('layouts.default')

@section('content')
<div class="container">
    <h1>Reports</h1>
    <ul class="list-group">
        <li class="list-group-item d-flex flex-row ">
            <span class="fa fa-user d-block pl-5 pr-5"></span>
            <a href="/reports/user/{{auth()->user()->id}}">User Report</a>
        </li>
        @if($isNotEmployee)
        <li class="list-group-item d-flex">
            <span class="fa fa-users d-block pl-5 pr-5"></span>
            <a href="/reports/all">All Users Report</a>
        </li>
        @endif
    </ul>
</div>
@endsection