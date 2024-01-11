@extends('layouts.app')

@section('content')
@if (session()->has('message'))
    <div class="container alert alert-warning" role="alert">
        {{session()->get('message')}}
    </div> 
@endif
    <div class="container">
        <h5 class="d-flex fw-bold justify-content-center pb-3">قائمة الأقسام </h5>
        <table class="table table-bordered">
            <tr>
                <th class="centered-content">#</th>
                <th class="centered-content">اسم القسم باللغة العربية</th>
                <th class="centered-content">اسم القسم باللغة الانكليزية</th>
                <th class="centered-content" colspan="2"><a href="/const/department/create"><button type="button" class="btn btn-primary my-1">إضافة قسم جديد</button></a></th>
            </tr>
            @php
                $count = 0;
            @endphp
            @foreach ($departments as $department)        
                <tr class="pt-3 ">
                    @php
                        $count++;
                    @endphp
                    <td class="fw-bold centered-content">{{$count}}</td>
                    <td class="centered-content">{{$department -> department}}</td>
                    <td class="centered-content">{{$department -> department_en}}</td>
                    <td class="centered-content">
                        <form action="/const/department/{{$department -> id}}" method="POST">   
                            @csrf
                            @method("DELETE")
                            <a href="/const/department/{{$department -> id}}/edit"><button type="button" class="btn btn-success my-1"><i class="fa fa-edit"></i></button></a>
                            <button type="submit" class="btn btn-danger my-1" onclick ="return confirm('هل تريد بالتأكيد حذف هذا القسم ؟')"><i class="fa fa-trash"></i></button>  
                        </form>  
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection