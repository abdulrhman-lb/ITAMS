@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">تعديل التصنيف </div>
                <div class="card-body">
                    <form method="POST" action="/const/class/{{$classes -> id}}"">
                        @csrf
                        @method('PUT')
                        <div class="row mb-3">
                            <label for="class" class="col-md-4 col-form-label text-md-end">التصنيف الجديد</label>
                            <div class="col-md-6">
                                <input id="class" type="text" class="form-control @error('class') is-invalid @enderror" name="class" value="{{$classes -> class}}">
                                @error('class')
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