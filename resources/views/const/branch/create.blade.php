@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">إضافة فرع جديد</div>
                <div class="card-body">
                    <form method="POST" action="/const/branch">
                        @csrf
                        <div class="row mb-3">
                            <label for="branch" class="col-md-4 col-form-label text-md-end">الفرع الجديد</label>
                            <div class="col-md-6">
                                <input id="branch" type="text" class="form-control @error('branch') is-invalid @enderror" name="branch" value="{{ old('branch') }}">
                                @error('branch')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="branch_en" class="col-md-4 col-form-label text-md-end">الفرع الجديد باللغة الانكليزية</label>
                            <div class="col-md-6">
                                <input id="branch_en" type="text" class="form-control @error('branch_en') is-invalid @enderror" name="branch_en" value="{{ old('branch_en') }}">
                                @error('branch_en')
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