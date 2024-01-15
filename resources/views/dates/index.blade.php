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
                    تنقلات الجهاز المحدد - الاستلام والتسليم
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-8">

                            <div class="row mb-3">
                                <div class="col-3"><label for="branch_id" class="col-md-12 col-form-label text-center">التصنيف</label></div>
                                <div class="col-3"><label for="branch_id" class="col-md-12 col-form-label text-center">الصنف</label></div>
                                <div class="col-3"><label for="branch_id" class="col-md-12 col-form-label text-center">الموديل</label></div>
                                <div class="col-3"><label for="branch_id" class="col-md-12 col-form-label text-center">الرقم المتسلسل</label></div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-3 fw-bold"><label for="branch_id" class="col-md-12 col-form-label text-center">{{$list['devices'] -> class -> class}}</label></div>
                                <div class="col-3 fw-bold"><label for="branch_id" class="col-md-12 col-form-label text-center">{{$list['devices'] -> category -> category}}</label></div>
                                <div class="col-3 fw-bold"><label for="branch_id" class="col-md-12 col-form-label text-center">{{$list['devices'] -> model -> model}}</label></div>
                                <div class="col-3 fw-bold"><label for="branch_id" class="col-md-12 col-form-label text-center">{{$list['devices'] -> serial_number}}</label></div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-3"><label for="branch_id" class="col-md-12 col-form-label text-center">الحالة الفنية</label></div>
                                <div class="col-3"><label for="branch_id" class="col-md-12 col-form-label text-center">اسم المستلم</label></div>
                                <div class="col-3"><label for="branch_id" class="col-md-12 col-form-label text-center">الفرع</label></div>
                                <div class="col-3"><label for="branch_id" class="col-md-12 col-form-label text-center">القسم</label></div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-3 fw-bold"><label for="branch_id" class="col-md-12 col-form-label text-center">{{$list['devices'] -> status -> status}}</label></div>
                                <div class="col-3 fw-bold"><label for="branch_id" class="col-md-12 col-form-label text-center">{{is_null($list['devices'] -> employee) ? ' - ' : $list['devices'] -> employee -> full_name}}</label></div>
                                <div class="col-3 fw-bold"><label for="branch_id" class="col-md-12 col-form-label text-center">{{$list['devices'] -> branch -> branch }}</label></div>
                                <div class="col-3 fw-bold"><label for="branch_id" class="col-md-12 col-form-label text-center">{{is_null($list['devices'] -> employee) ? ' - ' : $list['devices'] -> employee -> department -> department}}</label></div>
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="row mb-3">

                                @php
                                $image = '';
                                    if (($list['devices'] -> model -> image) == '' ) {
                                        $image = 'model/non.png';
                                    } else {
                                        $image = 'model/' . $list['devices'] -> model -> image; 
                                    }
                                @endphp 
                                <a href="/images/{{$image}}" data-lightbox="post-image" data-title="{{$list['devices'] -> model -> model}}">
                                    <img src="/images/{{$image}}" alt="{{$list['devices'] -> model -> model}}" class="img-pro-show-box">
                                </a>

                            </div>
                            <form action="{{route('dates-add')}}" method="POST">
                                @csrf
                                <input type="hidden" name="device_id" value="{{$list['devices'] -> id}}">
                                <input type="hidden" name="back" value="{{$list['back']}}">
                                <div class="row mb-3">
                                    <select class="form-select @error('employee_id') is-invalid @enderror" id="employee_id" name="employee_id">
                                        <option value="" selected>اختر الموظف الذي تريد نقل الجهاز له ...</option>
                                        @foreach ($list['employees'] as $employee)
                                            <option value="{{$employee -> id}}">{{$employee -> full_name}}</option>
                                        @endforeach
                                    </select>
                                    @error('employee_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                </div>
                                <div class="row mb-3">
                                    <button type="submit" name="change" class="btn btn-dark">نقل الجهاز إلى الموظف المحدد     <i class="fa fa-braille"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <table class="table table-bordered">
        <tr>
            <th class="centered-content">#</th>
            <th class="centered-content">اسم الموظف</th>
            <th class="centered-content">الفرع</th>
            <th class="centered-content">الشعبة</th>
            <th class="centered-content">القسم</th>
            <th class="centered-content">تاريخ الاستلام</th>
            <th class="centered-content">تاريخ التسليم</th>
        </tr>
        @php
            $count = 0;
        @endphp
        @foreach ($list['dates'] as $dates)        
            <tr class="pt-3 ">
                @php
                    $count++;
                @endphp
                <td class="fw-bold centered-content">{{$count}}</td>
                <td class="centered-content">{{$dates -> employee -> full_name}}</td>
                <td class="centered-content">{{$dates -> branch -> branch}}</td>
                <td class="centered-content">{{$dates -> sub_branch -> sub_branch}}</td>
                <td class="centered-content">{{$dates -> department -> department}}</td>
                <td class="centered-content">{{$dates -> start_date}}</td>
                <td class="centered-content">{{$dates -> end_date}}</td>
            </tr>
        @endforeach
    </table>
    <form action="{{route('export-dates',$list['devices'] -> id)}}" method="get">
        @csrf
        <div class="row mb-3 text-center" style="justify-content: center;">
            <input type="hidden" name="device_id" value="{{$list['devices'] -> id}}">
            <input type="hidden" name="class" value="{{$list['devices'] -> class -> class}}">
            <input type="hidden" name="category" value="{{$list['devices'] -> category -> category}}">
            <input type="hidden" name="model" value="{{$list['devices'] -> model -> model}}">
            <input type="hidden" name="status" value="{{$list['devices'] -> status -> status}}">
            <input type="hidden" name="serial_number" value="{{$list['devices'] -> serial_number}}">

            @if (!is_null($list['devices'] -> employee))
                <input type="hidden" name="employee" value="{{$list['devices'] -> employee -> full_name}}">
                <input type="hidden" name="branch" value="{{$list['devices'] -> employee -> branch -> branch}}">
                <input type="hidden" name="sub_branch" value="{{$list['devices'] -> employee -> sub_branch -> sub_branch}}">
                <input type="hidden" name="department" value="{{$list['devices'] -> employee -> department -> department}}">
                <input type="hidden" name="jop_title" value="{{$list['devices'] -> employee -> jop_title -> jop_title}}">
            @endif
            
            <input type="hidden" name="processor" value="{{!is_null($list['devices'] -> processor) ? $list['devices'] -> processor -> processor : ' - '}}">
            <input type="hidden" name="memory1" value="{{!is_null($list['devices'] -> memory1) ? $list['devices'] -> memory1 -> kind . ' ' . $list['devices'] -> memory1 -> size . ' GB' : ' - '}}">
            <input type="hidden" name="memory2" value="{{!is_null($list['devices'] -> memory2) ? $list['devices'] -> memory2 -> kind . ' ' . $list['devices'] -> memory2 -> size . ' GB' : ' - '}}">
            <input type="hidden" name="hard_disk1" value="{{!is_null($list['devices'] -> hard_disk1) ? $list['devices'] -> hard_disk1 -> kind . ' ' . $list['devices'] -> hard_disk1 -> size . ' GB' : ' - '}}">
            <input type="hidden" name="hard_disk2" value="{{!is_null($list['devices'] -> hard_disk2) ? $list['devices'] -> hard_disk2 -> kind . ' ' . $list['devices'] -> hard_disk2 -> size . ' GB' : ' - '}}">

            <button type="submit" class="btn btn-dark mt-3" style="width: 50%">تصدير إلى اكسل <i class="fa fa-file-excel-o"></i></button>
        </div>
    </form>
</div>
@endsection