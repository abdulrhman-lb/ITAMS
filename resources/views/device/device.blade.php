@extends('layouts.app')

@section('content')
@if (session()->has('message'))
    <div class="container alert alert-warning" role="alert">
        {{session()->get('message')}}
    </div> 
@endif

<div class="container">
    <div class="row justify-content-center pb-2">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-center fw-bold">
                    العهدة الشخصية
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-12">

                            <div class="row mb-3">
                                <div class="col-1"><label for="branch_id" class="col-md-12 col-form-label text-center">الفرع</label></div>
                                <div class="col-1"><label for="branch_id" class="col-md-12 col-form-label text-center">الشعبة</label></div>
                                <div class="col-2"><label for="branch_id" class="col-md-12 col-form-label text-center">القسم</label></div>
                                <div class="col-2"><label for="branch_id" class="col-md-12 col-form-label text-center">اسم الموظف</label></div>
                                <div class="col-2"><label for="branch_id" class="col-md-12 col-form-label text-center">التوصيف الوظيفي</label></div>
                                <div class="col-4">
                                    <form action="{{route('dates-add-all')}}" method="POST">
                                        @csrf
                                        <input type="hidden" name="old_employee_id" value="{{$list['employees'] -> id}}">
                                        <div class="row mb-3">
                                            <select class="form-select @error('new_employee_id') is-invalid @enderror" id="new_employee_id" name="new_employee_id">
                                                <option value="" selected>اختر الموظف الذي تريد نقل كامل العهدة له ...</option>
                                                @foreach ($list['employees_list'] as $employee)
                                                    <option value="{{$employee -> id}}">{{$employee -> full_name}}</option>
                                                @endforeach
                                            </select>
                                            @error('new_employee_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        </div>
                                </div>
                                {{-- <div class="col-3"><label for="branch_id" class="col-md-12 col-form-label text-center">الرقم المتسلسل</label></div> --}}
                            </div>

                            <div class="row mb-3">
                                <div class="col-1 fw-bold"><label for="branch_id" class="col-md-12 col-form-label text-center">{{$list['employees'] -> branch -> branch}}</label></div>
                                <div class="col-1 fw-bold"><label for="branch_id" class="col-md-12 col-form-label text-center">{{$list['employees'] -> sub_branch -> sub_branch}}</label></div>
                                <div class="col-2 fw-bold"><label for="branch_id" class="col-md-12 col-form-label text-center">{{$list['employees'] -> department -> department}}</label></div>
                                <div class="col-2 fw-bold"><label for="branch_id" class="col-md-12 col-form-label text-center">{{$list['employees'] -> full_name}}</label></div>
                                <div class="col-2 fw-bold"><label for="branch_id" class="col-md-12 col-form-label text-center">{{$list['employees'] -> jop_title -> jop_title}}</label></div>
                                <div class="col-4 fw-bold">
                                    
                                        <div class="row mb-3">
                                            <button type="submit" name="change" class="btn btn-dark">نقل الأجهزة إلى الموظف المحدد     <i class="fa fa-braille"></i></button>
                                        </div>
                                    </form>
                                </div>
                                {{-- <div class="col-3 fw-bold"><label for="branch_id" class="col-md-12 col-form-label text-center">{{$list['devices'] -> serial_number}}</label></div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <table class="table table-bordered">
        <tr>
            <th class="centered-content">#</th>
            <th class="centered-content">التصنيف</th>
            <th class="centered-content">الصنف</th>
            <th class="centered-content">النوع</th>
            <th class="centered-content">الرقم المتسلسل</th>
            <th class="centered-content"></th>
        </tr>
        @php
            $count = 0;
        @endphp
        @foreach ($list['devices'] as $device)        
            <tr class="pt-3 ">
                @php
                    $count++;
                @endphp
                <td class="fw-bold centered-content">{{$count}}</td>
                <td class="centered-content">{{$device -> class -> class}}</td>
                <td class="centered-content">{{$device -> category -> category}}</td>
                <td class="centered-content">{{$device -> model -> model}}</td>
                <td class="centered-content">{{$device -> serial_number}}</td>
                <td class="centered-content">
                    <a href="{{route('dates',['id='.$device -> id,'branch_id='.$device -> branch_id,'back=1'])}}"><button type="button" title="استلام وتسليم" class="btn btn-secondary my-1"><i class="fa fa-retweet"></i><span class="badge"></span></button></a>
                </td>
            </tr>
        @endforeach
    </table>
    <form action="{{route('export-device-employee',$list['employees'] -> id)}}" method="get">
        @csrf
        <div class="row mb-3 text-center" style="justify-content: center;">
            <input type="hidden" name="branch" value="{{$list['employees'] -> branch -> branch}}">
            <input type="hidden" name="sub_branch" value="{{$list['employees'] -> sub_branch -> sub_branch}}">
            <input type="hidden" name="department" value="{{$list['employees'] -> department -> department}}">
            <input type="hidden" name="full_name" value="{{$list['employees'] -> full_name}}">
            <input type="hidden" name="jop_title" value="{{$list['employees'] -> jop_title -> jop_title}}">
            <input type="hidden" name="phone" value="{{$list['employees'] -> phone}}">
            <input type="hidden" name="mobile" value="{{$list['employees'] -> mobile}}">
            <input type="hidden" name="email" value="{{$list['employees'] -> email}}">
            <input type="hidden" name="employee_id" value="{{$list['employees'] -> id}}">
            <button type="submit" class="btn btn-dark mt-3" style="width: 50%">تصدير إلى اكسل <i class="fa fa-file-excel-o"></i></button>
        </div>
    </form>
</div>
@endsection