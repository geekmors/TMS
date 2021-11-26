@extends('layouts.default')

@section('content')
<div class="container">
    <h1>User Report</h1>
    @if(!$cuser)
    <p>User does not exist</p>
    @else
    <div id="filter" class="mt-4 border rounded p-3 bg-white">
        <h2>Filter</h2>
        <form action="" method="GET">
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="from_date">From:</label>
                        <input type="date" value="{{$params["from_date"]}}" name="from_date" id="from_date" class="form-control">
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="to_date">To:</label>
                        <input type="date" name="to_date" id="to_date" value="{{$params["to_date"]}}" class="form-control">
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="sort_Date">Sort Date:</label>
                        <select name="sort_date" id="sort_Date" class="form-control" value="{{$params["sort_date"]}}">
                            <option value="asc">ascending</option>
                            <option value="desc">descending</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-outline-success">Apply</button>
            </div>
        </form>
    </div>
    <div class="bg-white mt-4 border bg-white p-3 rounded">
    

    <h4 class="mt-4">Report for 
        @if($isNotEmployee)
            <select name="userSelect" value="{{$cuser["id"]}}" id="userSelect">
                @foreach($users as $_user)
                    <option {{$_user["id"] == $cuser["id"]?'selected':''}} value="{{$_user["id"]}}">{{$_user["first_name"].' '.$_user["last_name"]}}</option>
                @endforeach
            </select>
        @else
        {{$cuser["first_name"].' '.$cuser["last_name"]}}
        @endif
    </h4>
    <a href="/reports/user/{{$cuser["id"]}}/download/csv" class="btn btn-outline-success mt-3 mb-3 download-csv">
        <span class="fa fa-file-excel-o"></span>
        Export To CSV
    </a>
    <div id="report" class="mb-5">
        <table class="table border table-striped">
            <thead>
                <th>Date</th>
                <th>Hours Worked</th>
                <th>Hours (Decimal)</th>
                <th>Entries</th>
            </thead>
            <tbody>
                @foreach($reportData as $row)

                <tr>
                    <td>{{date('d-M-y', strtotime($row["date"].' '.$row["total_hours"]))}}</td>
                    <td>{{$row["hours_str"]}}</td>
                    <td>{{$row["hours_dec"]}}</td>
                    <td>
                        <button class="btn btn-outline-info rounded-circle show_entry" title="show entry" data-date-str="{{date('d-M-y', strtotime($row["date"].' '.$row["total_hours"]))}}" data-uid="{{$cuser["id"]}}" data-date="{{$row["date"]}}">
                            {{$row["entry_count"]}}
                        </button>
                    </td>
                </tr>

                @endforeach
            </tbody>
        </table>
    </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Entries for <span id="modal-date"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <table id="modal-content" class="table border table-striped">
                        <thead>
                            <th>Entry Name</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Total Time</th>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        let current_route = $('a.download-csv').attr('href') + window.location.search
        $('a.download-csv').attr('href', current_route)

    </script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(".show_entry").click(function(e) {
            var requestURL = '/reports/user/' + $(this).data('uid') + '/entries?date=' + $(this).data('date')
            
            $('#modal-date').text($(this).attr('data-date-str'))
            $.get(requestURL, function(data) {
                console.log(data)
                $('#modal-content tbody').empty()

                if (data.length == 0) {
                    $('#modal-content tbody').append(
                        `<p>No Entries to show</p>`
                    )
                } 
                else {

                    for (let entry of data) {
                        let $content = `
                        <tr>
                            <td>${entry.entry}</td>
                            <td>${entry.time_in}</td>
                            <td>${entry.time_out}</td>
                            <td>${entry.total_hours}</td>
                        </tr>
                        `
                        $('#modal-content tbody').append($content)
                    }
                }

                $("#exampleModalCenter").modal('show')
            })
        })

    </script>
    <script>
        $('#userSelect').change(function(e){
            console.log(window.location.href)
            var url = window.location.pathname.split('/')
            url.pop()
            url = url.join('/')+'/'+$(this).val()+window.location.search
            window.location.href = url
        })
    </script>
    @endif
</div>
@endsection
