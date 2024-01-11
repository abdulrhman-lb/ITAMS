@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">إضافة توصيف وظيفي جديد</div>
                <div class="card-body">
                    <form method="POST" action="/const/title">
                        @csrf
                        <div class="row mb-3">
                            <label for="jop_title" class="col-md-4 col-form-label text-md-end">التوصيف الوظيفي الجديد</label>
                            <div class="col-md-6">
                                <input id="jop_title" type="text" class="form-control @error('jop_title') is-invalid @enderror" name="jop_title" value="{{ old('jop_title') }}">
                                @error('jop_title')
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