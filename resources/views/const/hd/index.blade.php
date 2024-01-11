@extends('layouts.app')

@section('content')
@if (session()->has('message'))
    <div class="container alert alert-warning" role="alert">
        {{session()->get('message')}}
    </div> 
@endif
    <div class="container">
        <h5 class="d-flex fw-bold justify-content-center pb-3">قائمة الأقراص الصلبة </h5>
        <table class="table table-bordered">
            <tr>
                <th class="centered-content">#</th>
                <th class="centered-content">نوع القرص الصلب</th>
                <th class="centered-content">حجم القرص الصلب بالـ GB</th>
                <th class="centered-content" colspan="2"><a href="/const/hd/create"><button type="button" class="btn btn-primary my-1">إضافة قرص صلب جديد</button></a></th>
            </tr>
            @php
                $count = 0;
            @endphp
            @foreach ($hard_disks as $hard_disk)        
                <tr class="pt-3 ">
                    @php
                        $count++;
                    @endphp
                    <td class="fw-bold centered-content">{{$count}}</td>
                    <td class="centered-content">{{$hard_disk -> kind}}</td>
                    <td class="centered-content">{{$hard_disk -> size}}</td>
                    <td class="centered-content">
                        <form action="/const/hd/{{$hard_disk -> id}}" method="POST">   
                            @csrf
                            @method("DELETE")
                            <a href="/const/hd/{{$hard_disk -> id}}/edit"><button type="button" class="btn btn-success my-1"><i class="fa fa-edit"></i></button></a>
                            <button type="submit" class="btn btn-danger my-1" onclick ="return confirm('هل تريد بالتأكيد حذف هذا القرص الصلب ؟')"><i class="fa fa-trash"></i></button>  
                        </form>  
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection