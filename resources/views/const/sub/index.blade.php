@extends('layouts.app')

@section('content')
@if (session()->has('message'))
    <div class="container alert alert-warning" role="alert">
        {{session()->get('message')}}
    </div> 
@endif
    <div class="container">
        <h5 class="d-flex fw-bold justify-content-center pb-3">قائمة الشعب </h5>
        <table class="table table-bordered">
            <tr>
                <th class="centered-content">#</th>
                <th class="centered-content">الفرع</th>
                <th class="centered-content">اسم الشعبة باللغة العربية</th>
                <th class="centered-content">اسم الشعبة باللغة الانكليزية</th>
                <th class="centered-content" colspan="2"><a href="/const/sub/create"><button type="button" class="btn btn-dark my-1">إضافة جديدة  <i class="fa fa-plus-square"></i></button></a></th>
            </tr>
            @php
                $count = 0;
            @endphp
            @foreach ($sub_branches as $sub_branch)        
                <tr class="pt-3 ">
                    @php
                        $count++;
                    @endphp
                    <td class="fw-bold centered-content">{{$count}}</td>
                    <td class="centered-content">{{$sub_branch -> branch -> branch}}</td>
                    <td class="centered-content">{{$sub_branch -> sub_branch}}</td>
                    <td class="centered-content">{{$sub_branch -> sub_branch_en}}</td>
                    <td class="centered-content">
                    <form action="/const/sub/{{$sub_branch -> id}}" method="POST">   
                        @csrf
                        @method("DELETE")
                        <a href="/const/sub/{{$sub_branch -> id}}/edit"><button type="button" class="btn btn-secondary my-1"><i class="fa fa-edit"></i></button></a>
                        <button type="submit" class="btn btn-secondary my-1" onclick ="return confirm('هل تريد بالتأكيد حذف هذا الشعبة ؟')"><i class="fa fa-trash"></i></button>  
                    </form>  
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection