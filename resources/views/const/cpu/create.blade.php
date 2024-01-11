@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">إضافة معالج جديد</div>
                <div class="card-body">
                    <form method="POST" action="/const/cpu">
                        @csrf
                        <div class="row mb-3">
                            <label for="processor" class="col-md-4 col-form-label text-md-end">نوع المعالج الجديد</label>
                            <div class="col-md-6">
                                <input id="processor" type="text" class="form-control @error('processor') is-invalid @enderror" name="processor" value="{{ old('processor') }}">
                                @error('processor')
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