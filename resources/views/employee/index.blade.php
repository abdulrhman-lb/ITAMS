@extends('layouts.app')

@section('content')
@if (session()->has('message'))
    <div class="container alert alert-warning" role="alert">
        {{session()->get('message')}}
    </div> 
@endif
<div class="container">
    <div class="row justify-content-center mb-3">
        <form action="{{ route('employee_search')}}" method="post">   
            @csrf
            <div class="accordion" id="accordionPanelsStayOpenExample">
                <div class="accordion-item">
                <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                    <div class="fw-bold text-center">قائمة الموظفين {{' - ' . (Auth::user()->role == '1'  ? 'كل الفروع' : 'فرع ' . Auth::user()->branch->branch)}}</div>
                </button>
                </h2>
                <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse">
                    <div class="accordion-body">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row text-center">
                                        
                                        <div class="col-3">
                                            <div class="row mb-3">
                                                <label for="branch_id" class="col-md-4 col-form-label text-center">الفرع</label>
                                                <div class="col-md-8">
                                                    <select class="form-select" id="branch_id" name="branch_id">
                                                        <option value="">-</option>
                                                        @foreach ($list['branches'] as $branch)
                                                            <option value="{{$branch -> id}}" {{ $branch -> id == $list['search_branch'] ? 'selected' : ''}}>{{$branch -> branch}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
            
                                        <div class="col-3">
                                            <div class="row mb-3">
                                                <label for="sub_branch_id" class="col-md-4 col-form-label text-md-start">الشعبة</label>
                                                <div class="col-md-8">
                                                    <select class="form-select" id="sub_branch_id" name="sub_branch_id">
                                                        <option value="">-</option>
                                                        @foreach ($list['sub_branches'] as $sub_branch)
                                                            <option value="{{$sub_branch -> id}}" {{ $sub_branch -> id == $list['search_sub_branch'] ? 'selected' : ''}}>{{$sub_branch -> sub_branch .  ' - ' . $sub_branch -> sub_branch_en}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-3">
                                            <div class="row mb-3">
                                                <label for="department_id" class="col-md-4 col-form-label text-md-start">القسم</label>
                                                <div class="col-md-8">
                                                    <select class="form-select" id="department_id" name="department_id">
                                                        <option value="">-</option>
                                                        @foreach ($list['departments'] as $department)
                                                            <option value="{{$department -> id}}" {{ $department -> id == $list['search_department'] ? 'selected' : ''}}>{{$department -> department}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-3">
                                            <div class="row mb-3">
                                                <label for="full_name" class="col-md-4 col-form-label text-md-start">الاسم</label>
                                                <div class="col-md-8">
                                                    <input id="full_name" type="text" class="form-control" name="full_name" value="{{$list['search_full_name']}}">
                                                </div>
                                            </div>
                                        </div>
            

                                        <div class="col-5">
                                            <div class="row mb-3">
                                                <div class="col-md-6 offset-md-5">
                                                    <button type="submit" name="search" id="search" class="btn btn-dark" style="width: 100%">تصفية</button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-5">
                                            <div class="row mb-3">
                                                <div class="col-md-6 offset-md-5">
                                                    <button type="submit" name="clear" id="cancel" class="btn btn-dark" style="width: 100%" >مسح</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="row justify-content-center mb-3 mt-3">
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
                <th class="centered-content" colspan="2"><a href="employee/create"><button type="button" class="btn btn-dark my-1">إضافة جديدة  <i class="fa fa-plus-square"></i></button></a></th>	
            </tr>
            @php
                $count = 0;
            @endphp
            @foreach ($list['employees'] as $employee)        
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
                        <a href="/employee/{{$employee -> id}}/edit"><button type="button" class="btn btn-secondary my-1"><i class="fa fa-edit"></i></button></a>
                        <button type="submit" class="btn btn-secondary my-1" onclick ="return confirm('هل تريد بالتأكيد حذف هذا الموظف ؟')"><i class="fa fa-trash"></i></button>  
                        <a href="{{route('device-employee','id='.$employee -> id)}}"><button type="button" title="استلام وتسليم" class="btn btn-secondary my-1 notification"><i class="fa fa-retweet"></i><span class="badge">{{$employee -> devices_count}}</span></button></a>
                    </form>  
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
</div>
@endsection