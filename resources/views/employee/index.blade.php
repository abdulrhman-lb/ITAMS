@extends('layouts.app')

@section('content')
@if (session()->has('message'))
    <div class="container alert alert-warning" role="alert">
        {{session()->get('message')}}
    </div> 
@endif
    <div class="container">
        <h5 class="d-flex fw-bold justify-content-center pb-3">قائمة الموظفين {{' - ' . (Auth::user()->role == '1'  ? 'كل الفروع' : 'فرع ' . Auth::user()->branch->branch)}}</h5>
        <table class="table table-bordered">
            <tr>
                <th class="centered-content">#</th>
                <th class="centered-content">الفرع</th>
                <th class="centered-content">الشعبة</th>
                <th class="centered-content">القسم</th>
                <th class="centered-content">اسم الموظف</th>
                <th class="centered-content">المسمى الوظيفي</th>
                <th class="centered-content">رقم الهاتف</th>
                <th class="centered-content">رقم الموبايل</th>
                <th class="centered-content">البريد الالكتروني</th>
                <th class="centered-content" colspan="2"><a href="employee/create"><button type="button" class="btn btn-primary my-1">إضافة</button></a></th>
            </tr>
            @php
                $count = 0;
            @endphp
            @foreach ($employees as $employee)        
                <tr class="pt-3 ">
                    @php
                        $count++;
                    @endphp
                    <td class="fw-bold centered-content">{{$count}}</td>
                    <td class="centered-content {{$employee -> ena === '0' ? 'text-danger' : ''}}">{{$employee -> branch -> branch}}</td>
                    <td class="centered-content {{$employee -> ena == '0' ? 'text-danger' : ''}}">{{$employee -> sub_branch -> sub_branch}}</td>
                    <td class="centered-content {{$employee -> ena == '0' ? 'text-danger' : ''}}">{{$employee -> department -> department}}</td>
                    <td class="centered-content {{$employee -> ena == '0' ? 'text-danger' : ''}}">{{$employee -> full_name}}</td>
                    <td class="centered-content {{$employee -> ena == '0' ? 'text-danger' : ''}}">{{$employee -> jop_title -> jop_title}}</td>
                    <td class="centered-content {{$employee -> ena == '0' ? 'text-danger' : ''}}">{{$employee -> phone}}</td>
                    <td class="centered-content {{$employee -> ena == '0' ? 'text-danger' : ''}}">{{$employee -> mobile}}</td>
                    <td class="centered-content {{$employee -> ena == '0' ? 'text-danger' : ''}}">{{$employee -> email}}</td>
                    <td class="centered-content">
                    <form action="/employee/{{$employee -> id}}" method="POST">   
                        @csrf
                        @method("DELETE")
                        <a href="/employee/{{$employee -> id}}/edit"><button type="button" class="btn btn-success my-1"><i class="fa fa-edit"></i></button></a>
                        <button type="submit" class="btn btn-danger my-1" onclick ="return confirm('هل تريد بالتأكيد حذف هذا الموظف ؟')"><i class="fa fa-trash"></i></button>  
                        {{-- @if ($employee -> ena == '0')
                            <span class="m-2">|</span>
                            <a href=""><button type="button" title="المتدربين" class="btn btn-info my-1 notification"><i class="fas fa-book-reader"></i></button></a>
                        @endif --}}
                    </form>  
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection