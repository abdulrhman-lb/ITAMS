@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">إضافة قسم جديد</div>
                <div class="card-body">
                    <form method="POST" action="/const/department">
                        @csrf
                        <div class="row mb-3">
                            <label for="department" class="col-md-4 col-form-label text-md-end">القسم الجديد</label>
                            <div class="col-md-6">
                                <input id="department" type="text" class="form-control @error('department') is-invalid @enderror" name="department" value="{{ old('department') }}">
                                @error('department')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="department_en" class="col-md-4 col-form-label text-md-end">القسم الجديد باللغة الانكليزية</label>
                            <div class="col-md-6">
                                <input id="department_en" type="text" class="form-control @error('department_en') is-invalid @enderror" name="department_en" value="{{ old('department_en') }}">
                                @error('department_en')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
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