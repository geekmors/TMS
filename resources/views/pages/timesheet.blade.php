@extends('layouts.default')
@section('custom_css')
<link rel="stylesheet" href="/css/input.css">
@endsection
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
                        </label>
                        <!--{{date('H:i')}}-->
                        <input disabled step="1" type="time" id="start-time" name="start-time" value="" class="entry-inputs">
                    </div>
                    <div>
                    <label for="end-time">
                        <h5>Current Time: </h5>
                    </label>
                    <input disabled type="time" id="current-time" name="current-time" value="" class="entry-inputs">
                </div>
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
        @foreach($timeSheetEntries as $key=> $entrySummary)
        
        <ul class="list-group mb-4" id="EntryList">
            <li class="list-group-item list-group-item-secondary">
                {{date("D M d, Y", strtotime($entrySummary["date"]))}} 
                | {{$entrySummary["total_hours"]}} 
                | {{$entrySummary["ot_hours"]}} 
                | {{$entrySummary["regular_hours"]}} 
                | {{count($entrySummary["entries"])}}
            </li>
            @foreach($entrySummary["entries"] as $entry)
            <li class="list-group-item d-flex justify-content-around" data-id="{{$entry->id}}">
                <span class="item">
                    Entry Name:
                    <input class="entry-data entry-inputs" type="text" name="entry_name" placeholder="Entery a name" value="{{$entry->entry}}" data-backup="{{$entry->entry}}">
                    <div style="display:none" class="invalid-feedback-message text-center">Entry name cannot be blank</div>
                </span>
                <span class="item">
                    Date: <input class="entry-data entry-inputs" type="date" name="entry_date" value="{{$entry->date_worked}}" data-backup="{{$entry->date_worked}}">
                </span>
                <span class="item">
                    Time Start: <input class="entry-data entry-inputs" max="{{$entry->time_out}}" step="1" type="time" name="entry_start_time" id="" value="{{$entry->time_in}}" data-backup="{{$entry->time_in}}">
                    
                </span>
                <span class="item">
                    Time End: <input class="entry-data entry-inputs" min="{{$entry->time_in}}" step="1" type="time" name="entry_end_time" id="" value="{{$entry->time_out}}" data-backup="{{$entry->time_out}}">
                    

                </span>
                <span class="item">
                    Total Time: <span class="entry_elapsed_time" data-backup="{{$entry->total_hours}}">{{$entry->total_hours}}</span>
                </span>
                <button class="save btn btn-outline-primary" title="save" data-id="{{$entry->id}}" style="display:none;">
                    save
                    <span class="fa fa-save"></span>
                </button>
                <button data-id="{{$entry->id}}" class="cancel btn btn-outline-warning" title="cancel edits" style="display:none;">
                    cancel
                    <span class="fa fa-times">
                    </span>
                </button>
                <button data-id="{{$entry->id}}" class="resume btn btn-outline-success" title="resume entry">
                    Resume
                    <span class="fa fa-play"></span>
                </button>
            </li>
            @endforeach
        </ul>
        @endforeach
    </div>
</div>
<script src="{{asset('js/Timer.js')}}"></script>
<script src="{{asset('js/timesheet.js')}}"></script>
<script src="{{asset('js/entrylist.js')}}"></script>
@endsection
