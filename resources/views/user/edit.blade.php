@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">تعديل بيانات مستخدم </div>
                <div class="card-body">
                    <form method="POST" action="/user/{{$list['User'] -> id}}">
                        @csrf
                        @method('PUT')
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">اسم المستخدم</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $list['User'] -> name }}">
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">البريد الالكتروني</label>
                            <div class="col-md-6">
                                <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $list['User'] -> email }}">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="passwordd" class="col-md-4 col-form-label text-md-end">كلمة المرور : </label>
                            <div class="col-md-6">
                                <input id="passwordd" type="passwordd" class="form-control @error('passwordd') is-invalid @enderror" name="passwordd" value=""  placeholder="فارغ لعدم التغيير">
                                @error('passwordd')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="active" class="col-md-4 col-form-label text-md-end">فعال</label>
                            <div class="col-md-6">
                                <select class="form-select" id="active" name="active">
                                    <option value="1" {{$list['User'] -> active == '1' ? 'selected' : ''}}>فعال</option>
                                    <option value="0" {{$list['User'] -> active == '0' ? 'selected' : ''}}>غير فعال</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="role" class="col-md-4 col-form-label text-md-end">الصلاحيات</label>
                            <div class="col-md-6">
                                <select class="form-select" id="role" name="role">
                                    <option value="1" {{$list['User'] -> role == '1' ? 'selected' : ''}}>مدير نظام</option>
                                    <option value="0" {{$list['User'] -> role == '0' ? 'selected' : ''}}>مستخدم عادي</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="branch_id" class="col-md-4 col-form-label text-md-end">نطاق العمل</label>
                            <div class="col-md-6">
                                <select class="form-select" id="branch_id" name="branch_id">
                                    <option value="">-</option>
                                    @foreach ($list['branches'] as $branch)
                                        <option value="{{$branch -> id}}" {{ $branch -> id == $list['User'] -> branch_id ? 'selected' : ''}}>{{$branch -> branch}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">حفظ التعديلات</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection