@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">تعديل الصنف </div>
                <div class="card-body">
                    <form method="POST" action="/const/category/{{$list['categories'] -> id}}">
                        @csrf
                        @method('PUT')
                        <div class="row mb-3">
                            <label for="class_id" class="col-md-4 col-form-label text-md-end"> التصنيف</label>
                            <div class="col-md-6">
                                <select class="form-select @error('class_id') is-invalid @enderror" id="class_id" name="class_id">
                                    @foreach ($list['classes'] as $class)
                                    <option value="{{$class -> id}}" {{$class->id == $list['categories'] -> class_id  ? 'selected' : ''}}>{{$class -> class}}</option>
                                    @endforeach
                                </select>
                                @error('class_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="category" class="col-md-4 col-form-label text-md-end">الصنف</label>
                            <div class="col-md-6">
                                <input id="category" type="text" class="form-control @error('category') is-invalid @enderror" name="category" value="{{$list['categories'] -> category}}">
                                @error('category')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
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