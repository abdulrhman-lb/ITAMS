@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">تعديل الذاكرة </div>
                <div class="card-body">
                    <form method="POST" action="/const/mem/{{$memories -> id}}"">
                        @csrf
                        @method('PUT')
                        <div class="row mb-3">
                            <label for="kind" class="col-md-4 col-form-label text-md-end">نوع الذاكرة </label>
                            <div class="col-md-6">
                                <input id="kind" type="text" class="form-control @error('kind') is-invalid @enderror" name="kind" value="{{$memories -> kind}}">
                                @error('kind')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="size" class="col-md-4 col-form-label text-md-end">حجم الذاكرة بالـ GB</label>
                            <div class="col-md-6">
                                <input id="size" type="text" class="form-control @error('size') is-invalid @enderror" name="size" value="{{$memories -> size}}">
                                @error('size')
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