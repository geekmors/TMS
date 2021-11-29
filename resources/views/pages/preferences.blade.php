@extends('layouts.default')

@section('content')
<div class="col-12">
    <h1>Preferences</h1>
    </div>
<div class=" ml-3 pl-0 container preferencesContainer">
    <div class="col-4">
  @foreach($preferences as $preference)
            <img class="avatar_img" src="{{$preference->avatar}}">
        
        @endforeach
    </div>
    <div class="col-12 px-5"> 

     <form action="/preferences/update" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="col-12 my-4"><label  for="image">Change Avatar</label>
        <input type="file" name="image"/>
        </div>
            <div class="col-12 my-4">
            <label for="typo"> Typography </label>
            <select name="typo">
            @foreach($typography as $typography)
            <option>{{$typography->description}}</option>
        @endforeach
            </select>
    </div>        
        <div class="col-12 my-4">
            <label for="button"> DarkMode</label> 
         <a class="btn" href={{"/preferences/darkmode"}}>
                @if($state === 1)
                    <i class="fa fa-toggle-on"></i>
                @endif
                @if ($state === 0)
                    <i class="fa fa-toggle-off"></i>
                @endif
            </a>
          
          
            
        </div>  <div class="col-12 my-4">
         <input type="submit" value="Save Setting">
         </div>
        </form>
    
    
    
    </div>

</div>
<style>

label{
    font-weight:bold;
}
.preferencesContainer
{
    background:white;
    font-size:20px;
    padding:20px;
}
.avatar_img{
    width:300px;
    margin:70px;
    border-radius:30px;
    height:auto;
    border:1px solid black;
}

</style>


<script>
$(document).ready(()=>{

});
</script>

@endsection
