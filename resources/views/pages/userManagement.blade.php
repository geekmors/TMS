@extends('layouts.default')
<title>User Management</title>
@section('content')
<div class="container userManContainer">
    <h1>User Management</h1>
    <br>
    <div class="row">
        <div class="col-12">
            <h4>Filer Options</h4>
        </div>
    </div>
    
    <div class="overflowTable">
        <!--Row to filter the users search-->
        <div class="row rounded darkArea">
            <div class="col-8 border-right border-secondary my-auto">
                <!-- search account by first name section -->
                <form action="/user" method="POST">
                    @csrf
                    <div class="input-group mb-3">
                        <!-- redirects to page, but with search query -->
                        <button type="submit" value="search" class="input-group-text"><i class="fa fa-search"></i> Search</button>
                        <input type="text" class="form-control" aria-describedby="basic-addon3" name="searchName" placeholder="User's First Name">
                        <!-- redirects to normal page -->
                        <a href="/user" class="input-group-text"><i class="fa fa-times"></i> All</a>
                    </div>
                </form>
            </div>
            
            <!-- filter by role section -->
            <div class="col-4 my-auto">
                <label for="selRole">Role</label>
                <select name="selectedRole" id="selRole">
                    <option value="All">All</option>
                    <!-- displays all user roles on the drop down option -->
                    @foreach ($userRoles as $userRole)
                        <option value="{{ $userRole->id}}">{{ $userRole->description}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <br>

        <!-- results table -->
        <div class="row rounded darkArea">
            <table>
                <tr class="row border-bottom border-secondary tableRow" style="font-weight: bold">
                    <td class="col-1">ID</td>
                    <td class="col-3">Name</td>
                    <td class="col-3">Email</td>
                    <td class="col-3">Last Login</td>
                    <td class="col-2">Role</td>
                </tr>
                @foreach ($users as $users)
                    <tr class="row userProfile userrole{{$users->role_id}}">
                        <td class="col-1 my-auto">{{ $users->id }}</td>
                        <td class="col-3 my-auto">{{ $users->last_name }}, {{ $users->first_name }}</td>
                        <td class="col-3 my-auto">{{ $users->email }}</td>
                        <td class="col-3 my-auto">{{ $users->timestamp_lastlogin}}</td>
                        <td class="col-2 my-auto">
                            <select name="changeRole" data-user-id="{{$users->id}}" class="chRole" {{$users->id == auth()->user()->id ? "disabled" : ""}}>
                                @foreach ($userRoles as $userRole)
                                    <option value="{{ $userRole->id}}" @if ( $userRole->id ==  $users->role_id ) selected="true" disabled="disabled" @endif>{{ $userRole->description}}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                @endforeach
                @if($users == "[]")
                        <tr class="row">
                            <td class="col-12 my-auto">No Matches Found</td>
                        </tr>
                @endif
            </table>
        </div>
    </div>
</div>

<style>
    .userManContainer{
        margin-top: 110px;
    }

    .overflowTable{
        overflow: auto;
    }
    
    .input-group-text:hover{
        text-decoration: none;
        color: #495057;;
    }

    .darkArea{
        width: 1000px;
        padding: 10px;
        background: rgb(226, 225, 225);
    }

    .tableRow{
        width: 1000px;
    }

    table tr{
        text-align: center
    }

    .fa-pencil-square-o{
        font-size: 2rem;
        font-weight: bold;
    }
</style>

<script>
    $(document).ready(function(){
        //filtering by role ONLY - filter once the role option changes
        $("#selRole").on('change', function(){
            //get the selected value
            var selRoleVal = $(this).val();
            //check if all was selected
            if(selRoleVal == "All"){
                //show all profiles
                $('.userProfile').fadeIn();
            }
            else{
                //hide all profiles
                $('.userProfile').fadeOut();
                //show the selected ones
                $('.userrole'+selRoleVal).fadeIn();
                //alert(selRoleVal);
            }
        });
    });
</script>
@endsection