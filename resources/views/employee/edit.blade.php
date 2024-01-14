@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">تعديل موظف </div>
                <div class="card-body">
                    <form method="POST" action="/employee/{{$list['employees'] -> id}}">
                        @csrf
                        @method('PUT')
                        <div class="row mb-3">
                            <label for="branch_id" class="col-md-4 col-form-label text-md-end">اختر الفرع</label>
                            <div class="col-md-6">
                                <select class="form-select @error('branch_id') is-invalid @enderror" id="branch_id" name="branch_id">
                                    @foreach ($list['branches'] as $branch)
                                        <option value="{{$branch -> id}}" {{ $branch -> id == $list['employees'] -> branch_id ? 'selected' : ''}}>{{$branch -> branch}}</option>
                                    @endforeach
                                </select>
                                <span style="color: brown" role="alert">
                                    <strong>ملاحظة: عند تعديل الفرع لموظف محدد سيتم تعديل عائدة الأجهزة المستلمه من قبله إلى الفرع الجديد </strong>
                                </span>
                                @error('branch_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="sub_branch_id" class="col-md-4 col-form-label text-md-end">اختر الشعبة</label>
                            <div class="col-md-6">
                                <select class="form-select @error('sub_branch_id') is-invalid @enderror" id="sub_branch_id" name="sub_branch_id">
                                    @foreach ($list['sub_branches'] as $sub_branch)
                                        <option value="{{$sub_branch -> id}}" {{ $sub_branch -> id == $list['employees'] -> sub_branch_id ? 'selected' : ''}}>{{$sub_branch -> sub_branch}}</option>
                                    @endforeach
                                </select>
                                @error('sub_branch_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="department_id" class="col-md-4 col-form-label text-md-end">اختر القسم</label>
                            <div class="col-md-6">
                                <select class="form-select @error('department_id') is-invalid @enderror" id="department_id" name="department_id">
                                    <option value="">-</option>
                                    @foreach ($list['departments'] as $department)
                                    <option value="{{$department -> id}}" {{ $department -> id == $list['employees'] -> department_id ? 'selected' : ''}}>{{$department -> department  }}</option>
                                    @endforeach
                                </select>
                                @error('department_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="full_name" class="col-md-4 col-form-label text-md-end">اسم الموظف الكامل</label>
                            <div class="col-md-6">
                                <input id="full_name" type="text" class="form-control @error('full_name') is-invalid @enderror" name="full_name" value="{{ $list['employees'] -> full_name }}">
                                @error('full_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="jop_title_id" class="col-md-4 col-form-label text-md-end">اختر التوصيف الوظيفي</label>
                            <div class="col-md-6">
                                <select class="form-select @error('jop_title_id') is-invalid @enderror" id="jop_title_id" name="jop_title_id">
                                    <option value="">-</option>
                                    @foreach ($list['jop_titles'] as $jop_title)
                                    <option value="{{$jop_title -> id}}" {{ $jop_title -> id == $list['employees'] -> jop_title_id ? 'selected' : ''}}>{{$jop_title -> jop_title  }}</option>
                                    @endforeach
                                </select>
                                @error('jop_title_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="phone" class="col-md-4 col-form-label text-md-end">رقم الهاتف</label>
                            <div class="col-md-6">
                                <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ $list['employees'] -> phone }}">
                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="mobile" class="col-md-4 col-form-label text-md-end">رقم الموبايل</label>
                            <div class="col-md-6">
                                <input id="mobile" type="text" class="form-control @error('mobile') is-invalid @enderror" name="mobile" value="{{ $list['employees'] -> mobile }}">
                                @error('mobile')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">البريد الالكتروني</label>
                            <div class="col-md-6">
                                <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $list['employees'] -> email }}">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="ena" class="col-md-4 col-form-label text-md-end">حالة الموظف</label>
                            <div class="col-md-6">
                                <select class="form-select @error('ena') is-invalid @enderror" id="ena" name="ena">
                                    <option value="1" {{ $list['employees'] -> ena == '1' ? 'selected' : ''}}>فعال</option>
                                    <option value="0" {{ $list['employees'] -> ena == '0' ? 'selected' : ''}}>غير فعال</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">إضافة</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection