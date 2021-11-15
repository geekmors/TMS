@extends('layouts.default')

@section('content')
<div class="container">
    <h1>User Report</h1>
    @if(!$user)
    <p>User does not exist</p>
    @else
        <div id="filter">
            <form action="" method="GET">
            </form>
        </div>
        @if($isNotEmployee)
            <div id="searchEmployee">
                <form action="">
                    <input type="search" name="searchEmployee" placeholder="search for user" id="">
                </form>
            </div>
        @endif

        <div id="report">
            <table></table>
        </div>
    @endif
</div>
@endsection