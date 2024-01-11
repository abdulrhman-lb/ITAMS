@extends('layouts.app')

@section('content')
@if (session()->has('message'))
    <div class="container alert alert-warning" role="alert">
        {{session()->get('message')}}
    </div> 
@endif
    <div class="container">
        <h5 class="d-flex fw-bold justify-content-center pb-3">قائمة الموديلات </h5>
        <table class="table table-bordered">
            <tr>
                <th class="centered-content">#</th>
                <th class="centered-content">صورة</th>
                <th class="centered-content">التصنيف</th>
                <th class="centered-content">الموديلات وتعني HP ProBook G2 - Lenovo 81HN - سكنر .... الخ</th>
                <th class="centered-content" colspan="2"><a href="/const/model/create"><button type="button" class="btn btn-primary my-1">إضافة موديل جديد</button></a></th>
            </tr>
            @php
                $count = 0;
            @endphp
            @foreach ($models as $model)     
                @php
                    $count++;
                    $image = '';
                    if (($model -> image) == '' ) {
                        $image = 'model/non.png';
                    } else {
                        $image = 'model/' . $model -> image; 
                    }
                @endphp         
                <tr class="pt-3 ">
                    <td class="fw-bold centered-content">{{$count}}</td>
                    <td class="fw-bold centered-content">
                        <a href="/images/{{$image}}" data-lightbox="post-image" data-title="{{$model -> model}}">
                            <img src="/images/{{$image}}" alt="{{$model -> model}}" class="thumbnail img-pro-show"">
                        </a>
                    </td>
                    <td class="centered-content">{{$model -> category -> category}}</td>
                    <td class="centered-content">{{$model -> model}}</td>
                    <td class="centered-content">
                    <form action="/const/model/{{$model -> id}}" method="POST">   
                        @csrf
                        @method("DELETE")
                        <a href="/const/model/{{$model -> id}}/edit"><button type="button" class="btn btn-success my-1"><i class="fa fa-edit"></i></button></a>
                        <button type="submit" class="btn btn-danger my-1" onclick ="return confirm('هل تريد بالتأكيد حذف هذا الموديل ؟')"><i class="fa fa-trash"></i></button>  
                    </form>  
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection