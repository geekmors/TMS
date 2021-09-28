@extends('layouts.default')

@section('content')
<h1>Setup Time Management System</h1>
@if($hasData)
<div>
    <h2>You're account has been created</h2>
    <img src="{{$userSettings->avatar}}" alt="your google account avatar">
    <ul>

        <li>Name: {{$user->first_name." ".$user->last_name}}</li>
        <li>Email: {{$user->email}} </li>
        <li>Role: {{$role->description}}</li>
    </ul>
    <p>You can change your profile information after setup has been completed via the user settings page</p>
</div>
<div>
    <h2>System Settings</h2>
    <p style="font-weight:bold; margin-bottom:10px">
        Domain "{{explode('@', $user->email)[1]}}" will be added to the list of allowed domains.
    </p>
    
    <form action="" enctype="multipart/form-data" method="post" style="background-color:#e2e2e2; padding:20px;">
        @csrf
        @if (count($errors) > 0)
            <div style="color:red">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="form-group" style="margin-bottom:10px;">
            <label for="enforceDomainList"><input type="checkbox" name="enforceDomainList" value="1" id="enforceDomainList"> Enforce Domain List on login</label>
            <br>
            <br>

            <label for="companyLogo">Set Company Logo:</label>
            <input type="file" name="companyLogo" id="companyLogo" accept="image/png, image/jpeg" placeholder="allowed image types: jpeg, png">

        </div>
        <input type="hidden" name="domain" value="{{explode('@', $user->email)[1]}}">
        <button type="submit">Save</button> <button type="reset">Reset</button>

    </form>
</div>
@else
    <p>No data to show, user was not created successfully</p>
@endif
@endsection
