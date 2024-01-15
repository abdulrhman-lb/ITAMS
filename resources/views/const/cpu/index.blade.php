@extends('layouts.app')
@section('content')
@if (session()->has('message'))
    <div class="container alert alert-warning" role="alert">
        {{session()->get('message')}}
    </div> 
@endif
    <div class="container">
        <h5 class="d-flex fw-bold justify-content-center pb-3">قائمة المعالجات </h5>
        <table class="table table-bordered">
            <tr>
                <th class="centered-content">#</th>
                <th class="centered-content">نوع المعالج</th>
                <th class="centered-content" colspan="2"><a href="/const/cpu/create"><button type="button" class="btn btn-dark my-1">إضافة جديدة  <i class="fa fa-plus-square"></i></button></a></th>	
            </tr>
            @php
                $count = 0;
            @endphp
            @foreach ($processors as $processor)        
                <tr class="pt-3 ">
                    @php
                        $count++;
                    @endphp
                    <td class="fw-bold centered-content">{{$count}}</td>
                    <td class="centered-content">{{$processor -> processor}}</td>
                    <td class="centered-content">
                        <form action="/const/cpu/{{$processor -> id}}" method="POST">   
                            @csrf
                            @method("DELETE")
                            <a href="/const/cpu/{{$processor -> id}}/edit"><button type="button" class="btn btn-secondary my-1"><i class="fa fa-edit"></i></button></a>
                            <button type="submit" class="btn btn-secondary my-1" onclick ="return confirm('هل تريد بالتأكيد حذف هذا المعالج ؟')"><i class="fa fa-trash"></i></button>  
                        </form>  
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection