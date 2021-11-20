@extends('layouts.default')
<title>System Settings</title>

@section('content')
<!-- Pop up Modal -->
<div class="modal fade" id="myModal" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="/system-settings" method="POST">
                @csrf
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Add Domain</h4>
                </div>
            
                <!-- Modal body -->
                <div class="modal-body">
                    <div class ="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="dAdd">Domain Address:</label>
                                <input type="text" class="form-control" id="dAdd" name="dAdd" placeholder="Enter Address" required>
                            </div>
                        </div>
                    </div>
                </div>
        
                <!-- Modal footer -->
                <div class="modal-footer">
                    <div class ="row mx-auto">
                        <div class="col-sm-6">
                            <button type="submit" value="Add Domain" class="btn btn-primary"> Add </button>
                        </div>
                        <div class="col-sm-6">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Page Content -->
<div class="container enforcementContainer">
    <div class="row">
        <!-- Feedback of successful data insert -->
        @if (session('feedback'))
            <div class="col-12 alert alert-success">
                {{ session('feedback') }}
            </div>
        @endif

        <div class="col-12">
            <h2>Login Settings</h2>
        </div>
        <div class="col-12">
            <a class="btn" href={{"/system-settings/enforce"}}>
                @if($state === 1)
                    <i class="fa fa-toggle-on"></i>
                @endif
                @if ($state === 0)
                    <i class="fa fa-toggle-off"></i>
                @endif
            </a>
            <label class="form-check-label custom-checkbox" for="flexCheckDefault">Enforce Domain on Login</label>
        </div>
        <br><br>
        <div class="col-12">
            <div class="container">
                <span class="allDom">Allowed Domains </span><button type="submit" class="btn btn-success rounded-circle" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i></button>
                <!-- INSERTED DATA -->
                <div class="allowedDom rounded">
                    <table>
                        @foreach ($dName as $dName)
                        <tr class="border-bottom border-dark dataRow" id="siteDel{{$dName->id}}">
                            <td class="col-sm-11">
                                {{ $dName->domain_name }}
                            </td>
                            <td class="col-sm-1">
                                <!-- DELETE BUTTON FOR EACH RECORD -->
                                <a class="btn btn-danger" onclick="removeSite({{$dName->id}})"><i class="fa fa-trash-o"></i></a>
                                <!-- DELETE BUTTON END -->
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
                <!-- INSERTED DATA END -->
            </div>
        </div>
    </div>
</div>


<style>
    .enforcementContainer{
        margin-top: 110px;
    }

    .allDom{
        font-weight: bold;
        font-size: 1.2rem;
    }

    .fa-plus{
        padding: 3px 0;
    }

    .fa-toggle-off, .fa-toggle-on{
        font-weight: bold;
        font-size: 1.5rem;
    }

    .fa-toggle-off{
        color: red;
    }

    .fa-toggle-on{
        color: green;
    }

    .allowedDom{
        margin-top: 20px;
        background: rgb(189, 189, 189);
        /*temp*/
        width: 300px;
        height: 400px;
        overflow-y: scroll;
    }

    td{
        font-weight: 600;
        padding: 7px 0;
    }
</style>

<script>
    //button calls function for ajax deletion
    function removeSite(siteID){
        //merges the id passed with default id value of the container of that row
        var buttonID = "#siteDel"+siteID;
        $.ajax({
            url: "/system-settings/removeSite",
            type: "POST",
            data: {
                siteID: siteID				
            },
            success: function(dataResult){
                var dataResult = JSON.parse(dataResult);
                //if it succeeded to delete site, it will hide the button
                if(dataResult.statusCode==200){
                    $(buttonID).fadeOut();
                    Alert({status: true, message:'Successfully removed site'});
                }
                //if it failed to delete site, it will alert the user
                else if(dataResult.statusCode==201){
                    Alert({status: false, message:'Cannot removed the only site!'})
                }
                
            }
        });
    }
</script>
@endsection
