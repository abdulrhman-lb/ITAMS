@extends('layouts.app')

@section('content')
@if (session()->has('message'))
    <div class="container alert alert-warning" role="alert">
        {{session()->get('message')}}
    </div> 
@endif
    <div class="container">
        <h5 class="d-flex fw-bold justify-content-center pb-3">قائمة الفروع </h5>
        <table class="table table-bordered">
            <tr>
                <th class="centered-content">#</th>
                <th class="centered-content">اسم الفرع باللغة العربية</th>
                <th class="centered-content">اسم الفرع باللغة الانكليزية</th>
                <th class="centered-content" colspan="2"><a href="/const/branch/create"><button type="button" class="btn btn-primary my-1">إضافة فرع جديد</button></a></th>
            </tr>
            @php
                $count = 0;
            @endphp
            @foreach ($branches as $branch)        
                <tr class="pt-3 ">
                    @php
                        $count++;
                    @endphp
                    <td class="fw-bold centered-content">{{$count}}</td>
                    <td class="centered-content">{{$branch -> branch}}</td>
                    <td class="centered-content">{{$branch -> branch_en}}</td>
                    <td class="centered-content">
                        <form action="/const/branch/{{$branch -> id}}" method="POST">   
                            @csrf
                            @method("DELETE")
                            <a href="/const/branch/{{$branch -> id}}/edit"><button type="button" class="btn btn-success my-1"><i class="fa fa-edit"></i></button></a>
                            <button type="submit" class="btn btn-danger my-1" onclick ="return confirm('هل تريد بالتأكيد حذف هذا الفرع ؟')"><i class="fa fa-trash"></i></button>  
                        </form>  
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection