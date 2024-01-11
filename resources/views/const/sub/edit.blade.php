@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">تعديل الشعبة </div>
                <div class="card-body">
                    <form method="POST" action="/const/sub/{{$list['sub_branches'] -> id}}">
                        @csrf
                        @method('PUT')
                        <div class="row mb-3">
                            <label for="branch_id" class="col-md-4 col-form-label text-md-end"> الفرع</label>
                            <div class="col-md-6">
                                <select class="form-select @error('branch_id') is-invalid @enderror" id="branch_id" name="branch_id">
                                    @foreach ($list['branches'] as $branch)
                                    <option value="{{$branch -> id}}" {{$branch->id == $list['sub_branches'] -> branch_id  ? 'selected' : ''}}>{{$branch -> branch}}</option>
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
                            <label for="sub_branch" class="col-md-4 col-form-label text-md-end">الشعبة</label>
                            <div class="col-md-6">
                                <input id="sub_branch" type="text" class="form-control @error('sub_branch') is-invalid @enderror" name="sub_branch" value="{{$list['sub_branches'] -> sub_branch}}">
                                @error('sub_branch')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="sub_branch_en" class="col-md-4 col-form-label text-md-end">الشعبة باللغة الانكليزية</label>
                            <div class="col-md-6">
                                <input id="sub_branch_en" type="text" class="form-control @error('sub_branch_en') is-invalid @enderror" name="sub_branch_en" value="{{$list['sub_branches'] -> sub_branch_en}}">
                                @error('sub_branch_en')
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