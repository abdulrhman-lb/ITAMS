@extends('layouts.app')
@section('content')
@if (session()->has('message'))
    <div class="container alert alert-warning" role="alert">
        {{session()->get('message')}}
    </div> 
@endif
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center p-4 fw-bold">نظام إدارة أصول تجهيزات تقانة المعلومات</div>
                <div class="card-body">
                    <img src="images/itams.png" class="text-center rounded img-fluid p-5" alt="...">
                </div>
            </div>
        </div>
    </div>
</div>
  <div class="text-center ">
  </div>

@endsection