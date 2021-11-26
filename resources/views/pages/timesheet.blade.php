@extends('layouts.default')
@section('custom_css')
<link rel="stylesheet" href="/css/input.css">
@endsection
@section('custom_js')
<script src="https://cdn.jsdelivr.net/npm/ejs@3.1.6/ejs.min.js"></script>
@endsection
@section('content')
<!-- timesheet content -->
<div class="content">
    <div>
        <h4>New Entry:</h4>

        <div class="time-entry">
            <div class="entry-form">
                <div>
                    <input type="text" id="entry-name" name="entry-name" maxlength="80" value="" placeholder="Enter New Entry Title" class="entry-inputs mr-5">
                    <label for="entry-date">
                        <h5>Date:</h5>
                    </label>
                    <input type="date" id="entry-date" name="entry-date" value="{{date('Y-m-d')}}" class="entry-inputs"> <br> <!-- Needs to have the current date as default -->
                    <input type="text" name="holdResume" id="holdWhileSendingData" hidden value="">
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
    <div class="entryLog mt-5">
        <h2 class="mt-4 mb-3">Entry Log</h2>
        <div class="entry-log-list_filter-sort-bar p-3 bg-light shadow-sm mb-4">
        <h4>Filter Entry Log</h4>
            <form action="/timesheet" method="get">
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="fromDate">From</label>
                            <input class="form-control" type="date" value="{{$queryParams["from"]}}" id="fromDate" name="from">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="toDate">To</label>
                            <input class="form-control" type="date" value="{{$queryParams["to"]}}" id="toDate" name="to">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="sortDate">Sort Date</label>
                            <select class="form-control" value="{{$queryParams["sort_date"]}}" id="sortDate" name="sort_date">
                                <option {{$queryParams["sort_date"]=="asc"?"selected":""}} value="asc">Ascending</option>
                                <option {{$queryParams["sort_date"]=="desc"?"selected":""}} value="desc">Descending</option>
                            </select>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="sortStartTime">Sort Start Time</label>
                            <select class="form-control" value="{{$queryParams["sort_timeIn"]}}" id="sortStartTime" name="sort_starttime">
                                <option {{$queryParams["sort_timeIn"] == "asc"?"selected":""}} value="asc">Ascending</span></option>
                                <option {{$queryParams["sort_timeIn"] == "desc"?"selected":""}} value="desc">Descending</option>
                            </select>
                        </div>
                    </div>
                    <div class="col">
                        <button type="submit" class="btn btn-outline-secondary mt-4">Apply</button>
                    </div>
                </div>
            </form>
        </div>

        <div id="no-entries" class="bg-light p-3 shadow-sm" style="display:{{count($timeSheetEntries) == 0?"block":"none"}}">
            No entries were found from <span class="text-muted">{{date('D M d Y', strtotime($queryParams["from"]))}}</span> to <span class="text-muted">{{date('D M d Y', strtotime($queryParams["to"]))}}</span>.
        </div>

        <div class="entry-log-list">

        </div>
    </div>
</div>
@include('inc.timesheet_templates')
<style>
    .badge{
        font-size: 12px;
    }

</style>

<script src="{{asset('js/Timer.js')}}"></script>
<script src="{{asset('js/entrylist.js')}}"></script>
<script src="{{asset('js/timesheet.js')}}"></script>

    <style>

        .chronos-input{
            font-size: 14px;
            outline: none;
            border: gray 1px solid;
            padding: 10px;
            border-radius: 5px;
            background-color:white;
            text-align:left;
            width: 100%;
        }
        .entry-list-item td{
            vertical-align:middle;
        }
        .entry-inputs{
            background-color:white;

        }
        .entry-inputs:disabled{
            background-color: #f0f0f0
        }
    </style>
@endsection
