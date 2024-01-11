@extends('layouts.app')

@section('content')
@if (session()->has('message'))
    <div class="container alert alert-warning" role="alert">
        {{session()->get('message')}}
    </div> 
@endif
    <div class="container">
        <h5 class="d-flex fw-bold justify-content-center pb-3">إدارة المستخدمين </h5>
        <table class="table table-bordered">
            <tr>
                <th class="centered-content">#</th>
                <th class="centered-content">اسم المستخدم</th>
                <th class="centered-content">البريد الالكتروني</th>
                <th class="centered-content">الفعالية</th>
                <th class="centered-content">الصلاحيات ونطاق العمل</th>
                <th class="centered-content" colspan="2"></th>
            </tr>
            @php
                $count = 0;
            @endphp
            @foreach ($User as $user)        
                <tr class="pt-3 ">
                    @php
                        $count++;
                    @endphp
                    <td class="fw-bold centered-content">{{$count}}</td>
                    <td class="centered-content {{$user -> active == '0' ? 'text-danger' : ''}}">{{$user -> name}}</td>
                    <td class="centered-content {{$user -> active == '0' ? 'text-danger' : ''}}">{{$user -> email}}</td>
                    <td class="centered-content {{$user -> active == '0' ? 'text-danger' : ''}}">{{$user -> active == '1' ? 'فعال' : 'غير فعال'}}</td>
                    <td class="centered-content {{$user -> active == '0' ? 'text-danger' : ''}}">{{($user -> role == '1' ? 'مدير نظام' : 'مستخدم عادي : فرع ' . (is_null($user -> branch_id) ? 'غير مخصص' : $user -> branch -> branch))}}</td>
                    <td class="centered-content">
                        <a href="/user/{{$user -> id}}/edit"><button type="button" class="btn btn-success my-1"><i class="fa fa-edit"></i></button></a>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection