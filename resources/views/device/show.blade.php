@extends('layouts.app')
@section('content')
@if (session()->has('message'))
    <div class="container alert alert-warning" role="alert">
        {{session()->get('message')}}
    </div> 
@endif
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center p-4 fw-bold">{{$devices -> model -> model}}</div>
                    @php
                        $image = '';
                        if (($devices -> model -> image) == '' ) {
                            $image = 'model/non.png';
                        } else {
                            $image = 'model/' . $devices -> model -> image; 
                        }
                    @endphp 
                    <div class="card mb-3" style="max-width: 100%; max-height: 100%">
                        <div class="row g-0">
                          <div class="col-md-4 p-3">
                            <a href="/images/{{$image}}" data-lightbox="post-image" data-title="{{$devices -> model -> model}}">
                                <img src="/images/{{$image}}" alt="{{$devices -> model -> model}}" class="thumbnail img-fluid rounded-start">
                            </a>
                          </div>
                          <div class="col-md-8">
                            <div class="card-body">
                                @php
                                    if (is_null($devices -> processor)) {
                                        $processor = '-';
                                    } else {
                                        $processor = $devices -> processor -> processor;
                                    }

                                    if (is_null($devices -> memory1)) {
                                        $memory1 = '-';
                                    } else {
                                        $memory1 = $devices -> memory1 -> kind . ' - ' . $devices -> memory1 -> size;
                                    }
                                    
                                    if (is_null($devices -> memory2)) {
                                        $memory2 = '-';
                                    } else {
                                        $memory2 = $devices -> memory2 -> kind . ' - ' . $devices -> memory2 -> size;
                                    }

                                    if (is_null($devices -> hard_disk1)) {
                                        $hard_disk1 = '-';
                                    } else {
                                        $hard_disk1 = $devices -> hard_disk1 -> kind . ' - ' . $devices -> hard_disk1 -> size;
                                    }

                                    if (is_null($devices -> hard_disk2)) {
                                        $hard_disk2 = '-';
                                    } else {
                                        $hard_disk2 = $devices -> hard_disk2 -> kind . ' - ' . $devices -> hard_disk2 -> size;
                                    }
                                    
                                    if (is_null($devices -> employee)) {
                                        $full_name = ' - ';
                                        $sub_branch = ' - ';
                                        $department = ' - ';
                                    } else {
                                        $full_name = $device -> employee -> full_name;
                                        $sub_branch = $devices -> employee -> sub_branch -> sub_branch;
                                        $department = $devices -> employee -> department -> department;
                                    }
                                @endphp
                                <table class="table table-bordered">
                                    <tr>
                                        <td class="fw-bold centered-content">الفرع</td>
                                        <td class="centered-content" colspan="2">{{$devices -> branch -> branch}}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold centered-content">الصنف</td>
                                        <td class="centered-content" colspan="2">{{$devices -> class -> class}}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold centered-content">التصنيف</td>
                                        <td class="centered-content" colspan="2">{{$devices -> category -> category}}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold centered-content">الموديل</td>
                                        <td class="centered-content" colspan="2">{{$devices -> model -> model}}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold centered-content" >الحالة الفنية</td>
                                        <td class="centered-content" colspan="2">{{$devices -> status -> status}}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold centered-content">المحلقات</td>
                                        <td class="centered-content" colspan="2">{{$devices -> accossories}}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold centered-content">المعالج</td>
                                        <td class="centered-content" colspan="2">{{$processor}}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold centered-content">الذاكرة</td>
                                        <td class="centered-content">{{$memory1}}</td>
                                        <td class="centered-content">{{$memory2}}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold centered-content">الهارد</td>
                                        <td class="centered-content">{{$hard_disk1}}</td>
                                        <td class="centered-content">{{$hard_disk1}}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold centered-content">ملاحظات</td>
                                        <td class="centered-content" colspan="2">{{$devices -> notes}}</td>
                                    </tr>
                                </table>
                                <table class="table table-bordered">
                                    <tr>
                                        <td class="fw-bold centered-content">اسم المستلم</td>
                                        <td class="centered-content">{{$full_name}}</td>
                                    </tr>

                                    <tr>
                                        <td class="fw-bold centered-content">الشعبة</td>
                                        <td class="centered-content">{{$sub_branch}}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold centered-content">القسم</td>
                                        <td class="centered-content">{{$department}}</td>
                                    </tr>
                                </table>
                            </div>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
  <div class="text-center ">
  </div>
@endsection