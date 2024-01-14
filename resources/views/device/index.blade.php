@extends('layouts.app')

@section('content')
@if (session()->has('message'))
    <div class="container alert alert-warning" role="alert">
        {{session()->get('message')}}
    </div> 
@endif
<div class="container" >
    <div class="row justify-content-center mb-3">

        <form action="{{ route('device_search')}}" method="post">   
            @csrf
            <div class="accordion" id="accordionPanelsStayOpenExample">
                <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                        <div class="fw-bold text-center">قائمة الأجهزة {{' - ' . (Auth::user()->role == '1'  ? 'كل الفروع' : 'فرع ' . Auth::user()->branch->branch)}}</div>
                    </button>
                </h2>
                <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse">
                    <div class="accordion-body">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row text-center">
                                        <div class="col">
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

                                            <div class="row mb-3">
                                                <label for="class_id" class="col-md-4 col-form-label text-center">التصنيف</label>
                                                <div class="col-md-8">
                                                    <select class="form-select" id="class_id" name="class_id">
                                                        <option value="">-</option>
                                                            @foreach ($list['classes'] as $class)
                                                                <option value="{{$class -> id}}" {{ $class -> id == $list['search_class'] ? 'selected' : ''}}>{{$class -> class}}</option>
                                                            @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="status_id" class="col-md-4 col-form-label text-center">الحالة الفنية</label>
                                                <div class="col-md-8">
                                                    <select class="form-select" id="status_id" name="status_id">
                                                        <option value="">-</option>
                                                        @foreach ($list['statuses'] as $status)
                                                            <option value="{{$status -> id}}" {{ $status -> id == $list['search_status'] ? 'selected' : ''}}>{{$status -> status}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
            
                                        <div class="col">
                                            <div class="row mb-3">
                                                <label for="sub_branch_id" class="col-md-3 col-form-label text-md-start">الشعبة</label>
                                                <div class="col-md-8">
                                                    <select class="form-select" id="sub_branch_id" name="sub_branch_id">
                                                        <option value="">-</option>
                                                        @foreach ($list['sub_branches'] as $sub_branch)
                                                            <option value="{{$sub_branch -> id}}" {{ $sub_branch -> id == $list['search_sub_branch'] ? 'selected' : ''}}>{{$sub_branch -> sub_branch .  ' - ' . $sub_branch -> sub_branch_en}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="category_id" class="col-md-3 col-form-label text-md-start">الصنف</label>
                                                <div class="col-md-8">
                                                    <select class="form-select" id="category_id" name="category_id">
                                                        <option value="">-</option>
                                                        @foreach ($list['categories'] as $category)
                                                            <option value="{{$category -> id}}" {{ $category -> id == $list['search_category'] ? 'selected' : ''}}>{{$category -> category}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="serial" class="col-md-3 col-form-label text-md-start">S/N</label>
                                                <div class="col-md-8">
                                                    <input id="serial" type="text" class="form-control" name="serial" value="{{$list['search_serial_number']}}">
                                                </div>
                                            </div>
                                        </div>
            
                                        <div class="col ">
                                            <div class="row mb-3">
                                                <label for="department_id" class="col-md-3 col-form-label text-md-start">القسم</label>
                                                <div class="col-md-8">
                                                    <select class="form-select" id="department_id" name="department_id">
                                                        <option value="">-</option>
                                                        @foreach ($list['departments'] as $department)
                                                            <option value="{{$department -> id}}" {{ $department -> id == $list['search_department'] ? 'selected' : ''}}>{{$department -> department}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="model_id" class="col-md-3 col-form-label text-md-start">الموديل</label>
                                                <div class="col-md-8">
                                                    <select class="form-select" id="model_id" name="model_id">
                                                        <option value="">-</option>
                                                        @foreach ($list['models'] as $model)
                                                            <option value="{{$model -> id}}" {{ $model -> id == $list['search_model'] ? 'selected' : ''}}>{{$model -> model}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <div class="col-md-12 offset-md-1">
                                                    <button type="submit" name="search" id="search" class="btn btn-primary" >تصفية</button>
                                                    <button type="submit" name="clear" id="cancel" class="btn btn-primary" >مسح</button>
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

        <div class="row justify-content-center mb-3 mt-3">
            <table class="table table-bordered ">
                <tr>
                    <th class="centered-content">#</th>
                    <th class="centered-content">صورة</th>
                    <th class="centered-content">الصنف</th>
                    <th class="centered-content">الموديل</th>
                    <th class="centered-content">S/N</th>
                    <th class="centered-content">اسم المستلم</th>
                    <th class="centered-content" colspan="2"><a href="device/create"><button type="button" class="btn btn-primary my-1">إضافة</button></a></th>
                </tr>
                @php
                    $count = 0;
                @endphp
                @foreach ($list['devices'] as $device)        
                    <tr class="pt-3 ">
                        @php
                            $count++;
                            $image = '';
                            if (($device -> model -> image) == '' ) {
                                $image = 'model/non.png';
                            } else {
                                $image = 'model/' . $device -> model -> image; 
                            }
                        @endphp 
                        <td class="fw-bold centered-content">{{$count}}</td>
                        <td class="centered-content" id="image">
                            <a href="/images/{{$image}}" data-lightbox="post-image" data-title="{{$device -> model -> model}}">
                                <img src="/images/{{$image}}" alt="{{$device -> model -> model}}" class="thumbnail img-pro-show"">
                            </a>
                        </td>
                        <td class="centered-content" id="category">{{$device -> category -> category}}</td>
                        <td class="centered-content" id="model">{{$device -> model -> model}}</td>
                        <td class="centered-content" id="serial_number">{{$device -> serial_number}}</td>
                        @php
                            if (is_null($device -> employee)) {
                                $full_name = ' - ';
                            } else {
                                $full_name = $device -> employee -> full_name;
                            }
                        @endphp
                        <td class="centered-content" id="full_name">{{$full_name}}</td>
                        <td class="centered-content">
                        <form action="/device/{{$device -> id}}" method="POST">   
                            @csrf
                            @method("DELETE")
                            <a href="/device/{{$device -> id}}"><button type="button" class="btn btn-primary my-1"><i class="fa fa-eye"></i></button></a>
                            <a href="/device/{{$device -> id}}/edit"><button type="button" class="btn btn-success my-1"><i class="fa fa-edit"></i></button></a>
                            <button type="submit" class="btn btn-danger my-1" onclick ="return confirm('هل تريد بالتأكيد حذف هذا الموظف ؟')"><i class="fa fa-trash"></i></button>  
                            <span class="m-2">|</span>
                            <a href="{{route('dates',['id='.$device -> id,'branch_id='.$device -> branch_id])}}"><button type="button" title="استلام وتسليم" class="btn btn-success my-1"><i class="fa fa-retweet"></i><span class="badge"></span></button></a>
                        </form>  
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>
@endsection