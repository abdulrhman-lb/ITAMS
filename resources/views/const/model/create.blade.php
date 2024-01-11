@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">إضافة موديل جديد</div>
                <div class="card-body">
                    <form method="POST" action="/const/model" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <label for="category_id" class="col-md-4 col-form-label text-md-end">اختر الصنف</label>
                            <div class="col-md-6">
                                <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id">
                                    @foreach ($categories as $category)
                                    <option value="{{$category -> id}}" {{ $category -> id == old('category_id') ? 'selected' : ''}}>{{$category -> category}}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="model" class="col-md-4 col-form-label text-md-end">الصنف الجديد</label>
                            <div class="col-md-6">
                                <input id="model" type="text" class="form-control @error('model') is-invalid @enderror" name="model" value="{{ old('model') }}">
                                @error('model')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="image" class="col-md-4 col-form-label text-md-end">إضافة صورة الموديل</label>
                            <div class="col-md-6">
                                <input class="form-control" type="file" id="image" name="image">
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