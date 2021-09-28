@extends('layouts.setup')

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
            <span >
                <input type="radio" name="imgType" value="file" checked> Upload File
                <input type="radio" name="imgType" value="url"> Use a URL
            </span> <br>
            <input type="file" name="companyLogo" id="companyLogo" accept="image/png, image/jpeg" placeholder="Enter image url">
            <p>If left empty then the default company logo will be used.</p>
            <h3>Current Logo:</h3>
            <img id="companyLogoImg" style="width:150px;" src="{{$logo}}" alt="current logo">

        </div>
        <input type="hidden" name="domain" value="{{explode('@', $user->email)[1]}}">
        <button type="submit">Save</button> <button type="reset">Reset</button>

    </form>
</div>
<script> // script to change company logo type from file to URL
    var img = document.getElementById('companyLogoImg')
    var imgFileUpload = document.getElementById('companyLogo')
    var imgTypes = document.querySelectorAll('[name="imgType"]')

    for(var imgType of imgTypes){
        imgType.addEventListener('change', function(e){
            if(this.value == "file"){
                imgFileUpload.type = "file"
            }else{
                imgFileUpload.type = "text"
            }
        })
    }

    imgFileUpload.addEventListener('change', function(){
        if(this.type == "file"){

            var fileReader = new FileReader()
            fileReader.readAsDataURL(this.files[0])
            fileReader.onload = function(eReader){
                img.src = eReader.target.result
            }
        }
        else img.src = imgFileUpload.value
    })
</script>
@else
    <p>No data to show, user was not created successfully</p>
@endif
@endsection
