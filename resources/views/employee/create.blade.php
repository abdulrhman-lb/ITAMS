@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">إضافة موظف جديد</div>
                <div class="card-body">
                    <form method="POST" action="/employee">
                        @csrf
                        <div class="row mb-3">
                            <label for="branch_id" class="col-md-4 col-form-label text-md-end">اختر الفرع</label>
                            <div class="col-md-6">
                                <select class="form-select @error('branch_id') is-invalid @enderror" id="branch_id" name="branch_id">
                                    <option value="">-</option>
                                    @foreach ($list['branches'] as $branch)
                                    <option value="{{$branch -> id}}" {{ $branch -> id == old('branch_id') ? 'selected' : ''}}>{{$branch -> branch}}</option>
                                    @endforeach
                                </select>
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
                                    <option value="{{$department -> id}}" {{ $department -> id == old('department_id') ? 'selected' : ''}}>{{$department -> department  }}</option>
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
                                <input id="full_name" type="text" class="form-control @error('full_name') is-invalid @enderror" name="full_name" value="{{ old('full_name') }}">
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
                                    <option value="{{$jop_title -> id}}" {{ $jop_title -> id == old('jop_title_id') ? 'selected' : ''}}>{{$jop_title -> jop_title  }}</option>
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
                                <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}">
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
                                <input id="mobile" type="text" class="form-control @error('mobile') is-invalid @enderror" name="mobile" value="{{ old('mobile') }}">
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
                                <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}">
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
                                    <option value="1">فعال</option>
                                    <option value="0">غير فعال</option>
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