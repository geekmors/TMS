<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!--[BEGIN meta definitions]-->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!--[END meta definitions]-->
    
    <title>{{config('app.name')}}</title>
    
    <!--[BEGIN css includes]-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
    
    @if(!auth()->check())
        <link rel="stylesheet" href="{{asset('css/setup.css')}}">
    @else
        <link rel="stylesheet" type="text/css" href="{{asset('css/nav.css')}}" media="screen"/>
        <link rel="stylesheet" type="text/css" href="{{asset('css/main.css')}}" media="screen">
    @endif
    
    @yield('custom_css')
    <!--[END css include]-->
    
    <!--[BEGIN top level JS script includes]-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
    <script src="{{asset('js/AppDB.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/Alert.js')}}" type="text/javascript"></script>
    @yield('custom_js')
    <!--[END top level JS script includes]-->

