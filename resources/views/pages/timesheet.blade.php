@extends('layouts.default')
@section('content')
<!-- timesheet content -->
<div class="content">
<div>
    <h4>Today:</h4>

    <div class="time-entry">
        <div class="entry-form">
            <div>
                <input type="text" id="entry-name" name="entry-name" value="" placeholder="Enter New Entry Title" class="entry-inputs mr-5">
                <label for="entry-date">
                    <h5>Date: </h5>
                </label>
                <input type="date" id="entry-date" name="entry-date" value="{{date('Y-m-d')}}" class="entry-inputs"> <br> <!-- Needs to have the current date as default -->
            </div>

            <div class="spacer"></div>

            <div class="time-inputs mx-auto">
                <div>
                    <label for="start-time">
                        <h5>Start Time: </h5>
                    </label><!--{{date('H:i')}}-->
                    <input disabled type="time" id="start-time" name="start-time" value="" class="entry-inputs">
                </div>
                <!--div>
                    <label for="end-time">
                        <h5>End Time: </h5>
                    </label>
                    <input disabled type="time" id="end-time" name="end-time" value="" class="entry-inputs">
                </div-->
                <div>
                    <label for="total-time">
                        <h5>Elapsed Time: </h5>
                    </label>
                    <span id="elapsed-time">00:00:00</span>
                    <!--input type="time" id="total-time" name="total-time" value="" class="entry-inputs"-->
                </div>
            </div>
        </div>
        <div class="ml-auto">
            <button type="button" class="btn btn-success start-timer">
            <span class="button-label">Start Timer</span>
            <i class="fa fa-play ml-2"></i></button>
            <button type="button" class="btn btn-danger stop-timer" style="display:none;">
            <span class="button-label">Stop Timer</span>
            <i class="fa fa-stop ml-2"></i></button>
        </div>
    </div>
</div>
<div class="entryLog mt-4">
<h2>Entry Log</h2>
    <ul class="list-group" id="EntryList">
        @foreach($entryLog as $entry)
            <li class="list-group-item">
            Entry Name:{{$entry->entry}} |
             Date: {{$entry->date_worked}} |
             Time Start: <input type="time" name="" id="" value="{{$entry->time_in}}"> |
             Time End: <input type="time" name="" id="" value="{{$entry->time_out}}">
            </li>
        @endforeach
    </ul>
</div>
</div>
<script src="{{asset('js/Timer.js')}}"></script>
<script src="{{asset('js/timesheet.js')}}"></script>
@endsection
