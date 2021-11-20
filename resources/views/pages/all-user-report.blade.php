@extends('layouts.default')

@section('content')
<div class="container">
    <h1>All User Reports</h1>
    <div class="filter rounded bg-light border p-2 mt-4 mb-4">
        <h2>Filter</h2>
        <form action="" method="get">
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="">From:</label>
                        <input type="date" name="from_date" id="" placeholder="from" value="{{$query_params["from_date"]}}" class="form-control">
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="">To:</label>
                        <input type="date" value="{{$query_params["to_date"]}}" name="to_date" id="" placeholder="to" class="form-control">
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="">Sort Date:</label>
                        <select name="sort_date" id="" class="form-control" value="{{$query_params["sort_date"]}}">
                            <option value="asc">Ascending</option>
                            <option value="desc">Descending</option>
                        </select>                    
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="">Sort Name:</label>
                        <select name="sort_name" id="" class="form-control" value="{{$query_params["sort_name"]}}">
                            <option value="asc">Ascending</option>
                            <option value="desc">Descending</option>
                        </select>                    
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="">Sort Total Hours:</label>
                        <select name="sort_hours" id="" class="form-control" value="{{$query_params["sort_hours"]}}">
                            <option value="asc">Ascending</option>
                            <option value="desc">Descending</option>
                        </select>                    
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col text-center">
                    <button type="submit" class="btn btn-outline-success">Apply</button>
                </div>
            </div>
        </form>
    </div>
    <div class="reportCon">
    <h2>Report</h2>
    <a href="/reports/all/download/csv" class="btn btn-outline-success mt-3 mb-3 download-csv">
        <span class="fa fa-file-excel-o"></span>
        Export To CSV
    </a>
    <table class="table table-striped border mb-5">
        <thead>
            <th>Date</th>
            <th>Name</th>
            <th>Hours Worked</th>
            <th>Hours (Decimal)</th>
        </thead>
        <tbody>
        @if(count($reportData) > 0)
            @foreach($reportData as $row)                
            <tr>
                <td>{{date('d-M-y', strtotime($row["date"].' '.$row["total_hours"]))}}</td>
                <td>{{$row["name"]}}</td>
                <td>{{$row["hours_str"]}}</td>
                <td>{{$row["hours_dec"]}}</td>
            </tr>
            @endforeach
        @else
        <p>No report data found.</p>
        @endif
        </tbody>
    </table>
    </div>

</div>
<script>
    let current_route = $('a.download-csv').attr('href') + window.location.search
    $('a.download-csv').attr('href', current_route)
</script>
@endsection