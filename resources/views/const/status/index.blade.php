@extends('layouts.app')
@section('content')
@if (session()->has('message'))
    <div class="container alert alert-warning" role="alert">
        {{session()->get('message')}}
    </div> 
@endif
    <div class="container">
        <h5 class="d-flex fw-bold justify-content-center pb-3">قائمة الحالة الفنية </h5>
        <table class="table table-bordered">
            <tr>
                <th class="centered-content">#</th>
                <th class="centered-content">الحالة الفنية للأجهزة</th>
                <th class="centered-content" colspan="2"><a href="/const/status/create"><button type="button" class="btn btn-primary my-1">إضافة</button></a></th>
            </tr>
            @php
                $count = 0;
            @endphp
            @foreach ($statuses as $status)        
                <tr class="pt-3 ">
                    @php
                        $count++;
                    @endphp
                    <td class="fw-bold centered-content">{{$count}}</td>
                    <td class="centered-content">{{$status -> status}}</td>
                    <td class="centered-content">
                        <form action="/const/status/{{$status -> id}}" method="POST">   
                            @csrf
                            @method("DELETE")
                            <a href="/const/status/{{$status -> id}}/edit"><button type="button" class="btn btn-success my-1"><i class="fa fa-edit"></i></button></a>
                            <button type="submit" class="btn btn-danger my-1" onclick ="return confirm('هل تريد بالتأكيد حذف هذا التوصيف الوظيفي ؟')"><i class="fa fa-trash"></i></button>  
                        </form>  
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection