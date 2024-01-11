@extends('layouts.app')
@section('content')
@if (session()->has('message'))
    <div class="container alert alert-warning" role="alert">
        {{session()->get('message')}}
    </div> 
@endif

  <div class="text-center ">
    <img src="images/itams.png" class="rounded img-fluid " alt="...">
  </div>

@endsection